<?php

namespace Tests\Feature;

use App\Filament\Widgets\LatestContactSubmissions;
use App\Models\ContactSubmission;
use App\Models\User;
use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardWidgetsTest extends TestCase
{
    use RefreshDatabase;

    private function signIn(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    private function submission(string $name, \Illuminate\Support\Carbon $at): ContactSubmission
    {
        $submission = ContactSubmission::create([
            'name' => $name,
            'phone' => '+962790000000',
            'email' => str($name)->slug().'@example.test',
            'message' => "message from {$name}",
        ]);

        $submission->forceFill(['created_at' => $at])->save();

        return $submission->refresh();
    }

    public function test_the_dashboard_shows_the_welcome_and_inquiries_widgets_only(): void
    {
        $this->signIn();

        $widgets = collect(Livewire::test(Dashboard::class)->instance()->getWidgets())
            ->map(fn ($widget) => is_string($widget) ? $widget : $widget::class)
            ->values();

        $this->assertContains(AccountWidget::class, $widgets->all());
        $this->assertContains(LatestContactSubmissions::class, $widgets->all());
        $this->assertNotContains(FilamentInfoWidget::class, $widgets->all());
        $this->assertSame(
            $widgets->unique()->count(),
            $widgets->count(),
            'a widget is registered twice, so it would render twice on the dashboard'
        );
        $this->assertCount(2, $widgets, 'unexpected widgets on the dashboard: '.$widgets->implode(', '));
    }

    public function test_the_dashboard_page_loads(): void
    {
        $this->signIn();

        // Widgets themselves are lazy Livewire components, so this only
        // proves the page and its widget placeholders render.
        $this->get('/backend')->assertStatus(200);
    }

    public function test_the_widget_lists_the_latest_inquiries_newest_first(): void
    {
        $this->signIn();

        // created_at is not fillable, so it has to be forced after creation.
        $older = $this->submission('Older Person', now()->subDays(3));
        $newer = $this->submission('Newer Person', now());

        Livewire::test(LatestContactSubmissions::class)
            ->assertCanSeeTableRecords([$newer, $older], inOrder: true)
            ->assertSee('Newer Person')
            ->assertSee('Latest Contact Inquiries');
    }

    public function test_the_widget_shows_at_most_ten_inquiries(): void
    {
        $this->signIn();

        foreach (range(1, 14) as $i) {
            $this->submission("Person {$i}", now()->subMinutes($i));
        }

        $widget = Livewire::test(LatestContactSubmissions::class);

        // assertCountTableRecords counts the unlimited query, so check the
        // records the widget actually renders.
        $this->assertCount(10, $widget->instance()->getTableRecords());
        $widget->assertSee('Person 1');       // newest
        $widget->assertDontSee('Person 14');  // oldest, past the cut
    }
}
