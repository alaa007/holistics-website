<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetVersioningTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_stylesheet_and_script_carry_a_version_stamp(): void
    {
        $this->seed();

        $html = $this->get('/')->assertStatus(200)->getContent();

        $this->assertMatchesRegularExpression('#assets/css/style\.css\?v=\d+#', $html);
        $this->assertMatchesRegularExpression('#assets/js/main\.js\?v=\d+#', $html);
    }

    public function test_the_stamp_follows_the_file_modification_time(): void
    {
        $this->assertSame(
            asset('assets/css/style.css').'?v='.filemtime(public_path('assets/css/style.css')),
            versioned_asset('assets/css/style.css')
        );
    }

    public function test_a_missing_file_falls_back_to_a_plain_url(): void
    {
        $this->assertSame(
            asset('assets/css/does-not-exist.css'),
            versioned_asset('assets/css/does-not-exist.css')
        );
    }

    /**
     * A preload only works if its URL is byte-identical to the one the
     * stylesheet requests. Versioning the font would make the browser fetch
     * it twice instead of once.
     */
    public function test_the_font_preload_is_not_versioned(): void
    {
        $this->seed();

        $html = $this->get('/ar')->assertStatus(200)->getContent();

        $this->assertStringContainsString(
            'href="'.asset('fonts/rubik/rubik-arabic.woff2').'" crossorigin',
            $html
        );
        $this->assertDoesNotMatchRegularExpression('#rubik-arabic\.woff2\?v=#', $html);
    }
}
