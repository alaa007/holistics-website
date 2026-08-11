<?php

namespace App\Http\Middleware;

use App\Support\Seo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! in_array($locale, Seo::LOCALES, true)) {
            // Unprefixed routes (the locale switcher, legacy redirects) still
            // need a locale for translated strings; fall back to the session.
            $locale = static::preferred($request);
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);

        // Lets route('about') resolve to /en/about without every call site
        // passing the locale explicitly.
        URL::defaults(['locale' => $locale]);

        // Route parameters are handed to controller actions positionally, so
        // leaving {locale} in place would land in the action's first argument
        // (ServiceController::show(Service $service) would receive "en").
        $request->route()?->forgetParameter('locale');

        return $next($request);
    }

    /**
     * Best guess at a visitor's locale for URLs that carry no prefix:
     * what they last chose, then their browser's preference, then the default.
     */
    public static function preferred(Request $request): string
    {
        $session = session('locale');

        if (in_array($session, Seo::LOCALES, true)) {
            return $session;
        }

        $browser = $request->getPreferredLanguage(Seo::LOCALES);

        if (in_array($browser, Seo::LOCALES, true)) {
            return $browser;
        }

        return in_array(config('app.locale'), Seo::LOCALES, true) ? config('app.locale') : 'en';
    }
}
