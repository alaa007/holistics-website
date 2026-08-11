<?php

use App\Support\Seo;
use Illuminate\Support\Facades\Route;

if (! function_exists('versioned_asset')) {
    /**
     * Asset URL with a cache-busting stamp taken from the file's last
     * modification time:
     *
     *     versioned_asset('assets/css/style.css')
     *     => http://example.com/assets/css/style.css?v=1786440000
     *
     * The URL changes whenever the file does, so a browser fetches the new
     * copy immediately instead of serving a stale one — and can cache it
     * hard in between. Falls back to a plain URL if the file is missing,
     * rather than emitting "?v=" or raising a warning.
     */
    function versioned_asset(string $path): string
    {
        static $stamps = [];

        $url = asset($path);

        if (! array_key_exists($path, $stamps)) {
            $file = public_path($path);
            $stamps[$path] = is_file($file) ? filemtime($file) : null;
        }

        return $stamps[$path] === null ? $url : "{$url}?v={$stamps[$path]}";
    }
}

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
