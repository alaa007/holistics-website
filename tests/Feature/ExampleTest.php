<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The root URL carries no locale, so it redirects to the prefixed home
     * page rather than rendering one.
     */
    public function test_the_root_url_redirects_to_a_localized_home_page(): void
    {
        $this->get('/')->assertRedirect('/en');
    }

    public function test_the_localized_home_page_returns_a_successful_response(): void
    {
        $this->get('/en')->assertStatus(200);
        $this->get('/ar')->assertStatus(200);
    }
}
