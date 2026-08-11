<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Auth\Pages\EditProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'email' => 'admin@example.test',
            'password' => Hash::make('old-password'),
        ]);
    }

    public function test_the_profile_page_loads(): void
    {
        $this->actingAs($this->admin());

        $this->get('/backend/profile')->assertStatus(200);
    }

    public function test_the_password_can_be_changed(): void
    {
        $user = $this->admin();
        $this->actingAs($user);

        Livewire::test(EditProfile::class)
            ->fillForm([
                'currentPassword' => 'old-password',
                'password' => 'a-much-better-password',
                'passwordConfirmation' => 'a-much-better-password',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertTrue(Hash::check('a-much-better-password', $user->refresh()->password));
    }

    public function test_changing_the_password_requires_the_current_one(): void
    {
        $user = $this->admin();
        $this->actingAs($user);

        Livewire::test(EditProfile::class)
            ->fillForm([
                'currentPassword' => 'not-the-current-password',
                'password' => 'a-much-better-password',
                'passwordConfirmation' => 'a-much-better-password',
            ])
            ->call('save')
            ->assertHasFormErrors(['currentPassword']);

        $this->assertTrue(Hash::check('old-password', $user->refresh()->password));
    }

    public function test_the_profile_page_is_not_reachable_when_signed_out(): void
    {
        $this->get('/backend/profile')->assertRedirect('/backend/login');
    }
}
