<?php

namespace Tests\Feature;

use App\Filament\Resources\HomeSlideResource;
use App\Filament\Resources\LeadershipMemberResource;
use App\Filament\Resources\MedicalTeamMemberResource;
use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\SpecialtyResource;
use App\Filament\Resources\StatResource;
use App\Filament\Resources\ValueResource;
use App\Filament\Resources\WhyUsItemResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TableReorderingTest extends TestCase
{
    use RefreshDatabase;

    public static function resourceProvider(): array
    {
        return [
            'home slides' => [HomeSlideResource::class],
            'leadership' => [LeadershipMemberResource::class],
            'medical team' => [MedicalTeamMemberResource::class],
            'services' => [ServiceResource::class],
            'specialties' => [SpecialtyResource::class],
            'stats' => [StatResource::class],
            'values' => [ValueResource::class],
            'why us items' => [WhyUsItemResource::class],
        ];
    }

    /**
     * Reverses the listed records via the table's reorder action and checks
     * the new positions were persisted to the order column.
     *
     */
    #[DataProvider('resourceProvider')]
    public function test_records_can_be_reordered(string $resource): void
    {
        $this->seed();
        $this->actingAs(User::first());

        $listPage = $resource::getPages()['index']->getPage();
        $model = $resource::getModel();

        $ids = $resource::getEloquentQuery()->orderBy('order')->pluck('id')->all();
        $this->assertGreaterThan(1, count($ids), 'need at least two records to reorder');

        Livewire::test($listPage)
            ->call('reorderTable', array_reverse($ids))
            ->assertHasNoErrors();

        $reordered = $model::query()
            ->whereIn('id', $ids)
            ->orderBy('order')
            ->pluck('id')
            ->all();

        $this->assertSame(array_reverse($ids), $reordered);
    }

    /**
     * Leadership and the medical team are two scoped views over the same
     * team_members table, so reordering one must not disturb the other.
     */
    public function test_reordering_leadership_leaves_the_medical_team_alone(): void
    {
        $this->seed();
        $this->actingAs(User::first());

        $medicalBefore = MedicalTeamMemberResource::getEloquentQuery()
            ->orderBy('order')->pluck('id')->all();

        $leadershipIds = LeadershipMemberResource::getEloquentQuery()
            ->orderBy('order')->pluck('id')->all();

        Livewire::test(LeadershipMemberResource::getPages()['index']->getPage())
            ->call('reorderTable', array_reverse($leadershipIds))
            ->assertHasNoErrors();

        $medicalAfter = MedicalTeamMemberResource::getEloquentQuery()
            ->orderBy('order')->pluck('id')->all();

        $this->assertSame($medicalBefore, $medicalAfter);
    }
}
