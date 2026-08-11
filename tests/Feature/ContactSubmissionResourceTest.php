<?php

namespace Tests\Feature;

use App\Filament\Resources\ContactSubmissionResource;
use App\Filament\Resources\ContactSubmissionResource\Pages\ListContactSubmissions;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactSubmissionResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_submissions_cannot_be_created_from_the_panel(): void
    {
        $this->assertFalse(ContactSubmissionResource::canCreate());
    }

    public function test_the_list_page_has_no_create_button(): void
    {
        Livewire::test(ListContactSubmissions::class)
            ->assertOk()
            ->assertDontSee('New contact submission')
            ->assertDontSee('Create');
    }

    public function test_the_create_route_no_longer_exists(): void
    {
        $this->assertArrayNotHasKey('create', ContactSubmissionResource::getPages());

        $this->get('/backend/contact-submissions/create')->assertNotFound();
    }

    public function test_the_list_and_edit_pages_still_work(): void
    {
        $submission = \App\Models\ContactSubmission::create([
            'name' => 'Someone', 'phone' => '+962790000000',
            'email' => 'someone@example.test', 'message' => 'hello',
        ]);

        $this->get('/backend/contact-submissions')->assertSuccessful();
        $this->get("/backend/contact-submissions/{$submission->id}/edit")->assertSuccessful();
    }
}
