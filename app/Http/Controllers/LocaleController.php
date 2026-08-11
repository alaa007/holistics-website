<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Support\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Kept for any link that still points at /lang/{locale}. The header now
     * links straight to the alternate URL, which is what a crawler should see.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, Seo::LOCALES, true)) {
            $locale = SetLocale::preferred($request);
        }

        session(['locale' => $locale]);

        return redirect()->route('home', ['locale' => $locale]);
    }

    /**
     * Sends a legacy unprefixed URL (/about) to its localized twin (/en/about).
     *
     * Deliberately a 302: the target depends on the visitor's session and
     * Accept-Language, so it differs between requests to the same URL. A 301
     * would be cached by the browser and any CDN, permanently pinning the
     * first visitor's language onto that URL for everyone behind the cache.
     */
    public function redirectToLocalized(Request $request): RedirectResponse
    {
        $locale = SetLocale::preferred($request);
        $path = trim($request->path(), '/');
        $target = $path === '' ? "/{$locale}" : "/{$locale}/{$path}";

        return redirect($target, 302);
    }
}
