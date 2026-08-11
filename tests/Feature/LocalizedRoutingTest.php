<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LocalizedRoutingTest extends TestCase
{
    use RefreshDatabase;

    public static function pageProvider(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/about'],
            'services' => ['/services'],
            'team' => ['/team'],
            'contact' => ['/contact'],
            'service detail' => ['/services/home-healthcare'],
        ];
    }

    #[DataProvider('pageProvider')]
    public function test_english_is_served_from_the_bare_path(string $path): void
    {
        $this->seed();

        $this->get($path)
            ->assertStatus(200)
            ->assertSee('lang="en"', false)
            ->assertSee('dir="ltr"', false);
    }

    #[DataProvider('pageProvider')]
    public function test_arabic_is_served_from_the_ar_prefix(string $path): void
    {
        $this->seed();

        $this->get('/ar'.rtrim($path, '/'))
            ->assertStatus(200)
            ->assertSee('lang="ar"', false)
            ->assertSee('dir="rtl"', false);
    }

    #[DataProvider('pageProvider')]
    public function test_the_old_en_prefix_redirects_permanently(string $path): void
    {
        $this->seed();

        $this->get('/en'.rtrim($path, '/'))
            ->assertStatus(301)
            ->assertRedirect($path);
    }

    public function test_links_on_an_arabic_page_stay_arabic(): void
    {
        $this->seed();

        $response = $this->get('/ar/about');

        // Navigation keeps the prefix...
        $response->assertSee('href="'.url('/ar/services').'"', false);
        $response->assertSee('href="'.url('/ar/team').'"', false);

        // ...while the language switcher and hreflang point at the bare path.
        $response->assertSee('href="'.url('/about').'"', false);
    }

    public function test_hreflang_and_canonical_describe_both_languages(): void
    {
        $this->seed();

        $this->get('/about')
            ->assertSee('<link rel="canonical" href="'.url('/about').'">', false)
            ->assertSee('hreflang="en" href="'.url('/about').'"', false)
            ->assertSee('hreflang="ar" href="'.url('/ar/about').'"', false);

        $this->get('/ar/about')
            ->assertSee('<link rel="canonical" href="'.url('/ar/about').'">', false)
            ->assertSee('hreflang="ar" href="'.url('/ar/about').'"', false);
    }

    public function test_the_sitemap_lists_both_languages(): void
    {
        $this->seed();

        $response = $this->get('/sitemap.xml')->assertStatus(200);

        $response->assertSee('<loc>'.url('/about').'</loc>', false);
        $response->assertSee('<loc>'.url('/ar/about').'</loc>', false);
        $response->assertDontSee(url('/en/'), false);
    }
}
