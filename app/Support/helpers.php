<?php

use App\Support\Seo;
use Illuminate\Support\Facades\Route;

if (! function_exists('localized_route')) {
    /**
     * URL for a public page in a given language.
     *
     * English routes are registered under their plain names and Arabic ones
     * under an "ar." prefix, so this only has to pick the right name:
     *
     *     localized_route('about')        => /about   (or /ar/about in Arabic)
     *     localized_route('about', [], 'ar') => /ar/about
     */
    function localized_route(string $name, mixed $parameters = [], ?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return route(Seo::routeNameFor($name, $locale), $parameters);
    }
}

if (! function_exists('localized_route_is')) {
    /**
     * Whether the current route is one of the given page names, ignoring the
     * locale prefix — so 'services.*' matches on both /services and
     * /ar/services. Used for active states in the navigation.
     */
    function localized_route_is(string ...$patterns): bool
    {
        $current = Seo::unlocalizedRouteName(Route::currentRouteName());

        if ($current === null) {
            return false;
        }

        foreach ($patterns as $pattern) {
            if (fnmatch($pattern, $current)) {
                return true;
            }
        }

        return false;
    }
}
