<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The migrations only build schema, so seed to give the record-bound
     * Edit pages something to resolve.
     */
    protected bool $seed = true;

    public function test_any_authenticated_user_can_access_the_panel_in_production(): void
    {
        // Guards the FilamentUser contract on User. Without it Filament falls
        // back to an environment check and 403s everyone outside "local".
        config(['app.env' => 'production']);

        $this->actingAs(User::factory()->create())
            ->get('/backend')
            ->assertSuccessful();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/backend')->assertRedirect('/backend/login');
    }

    public function test_every_admin_page_loads(): void
    {
        $this->actingAs(User::factory()->create());

        $results = [];

        foreach ($this->adminUrls() as $label => $url) {
            try {
                $status = $this->get($url)->getStatusCode();
            } catch (\Throwable $e) {
                $status = get_class($e).': '.$e->getMessage();
            }

            $results[$label.' ['.$url.']'] = $status;
        }

        $failures = array_filter($results, fn ($status) => $status !== 200);

        $this->assertSame(
            [],
            $failures,
            "Admin pages that did not return 200:\n".print_r($failures, true)
        );
    }

    /**
     * @return array<string, string>
     */
    private function adminUrls(): array
    {
        $urls = ['dashboard' => '/backend'];

        foreach (glob(app_path('Filament/Resources/*.php')) as $file) {
            $name = basename($file, '.php');
            $class = 'App\\Filament\\Resources\\'.$name;

            $record = $class::getModel()::query()->first();

            foreach (array_keys($class::getPages()) as $page) {
                if (in_array($page, ['edit', 'view'], true)) {
                    if (! $record) {
                        continue;
                    }

                    // Not getKey(): Service overrides getRouteKeyName() to
                    // "slug", and Filament resolves records by route key.
                    $url = $class::getUrl($page, ['record' => $record->getRouteKey()]);
                } else {
                    $url = $class::getUrl($page);
                }

                $urls[$name.'::'.$page] = parse_url($url, PHP_URL_PATH);
            }
        }

        return $urls;
    }
}
