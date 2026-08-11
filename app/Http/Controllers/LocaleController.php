<?php

namespace App\Http\Controllers;

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
            $locale = Seo::DEFAULT_LOCALE;
        }

        return redirect()->route(Seo::routeNameFor('home', $locale));
    }

    /**
     * Sends the /en/... URLs this site briefly used to their bare
     * equivalents: /en/about becomes /about.
     *
     * Permanent, unlike a language-detecting redirect: the target is a fixed
     * function of the path, so caching it cannot pin the wrong language onto
     * a URL for anyone.
     */
    public function redirectFromEnglishPrefix(Request $request, string $path): RedirectResponse
    {
        return redirect('/'.ltrim($path, '/'), 301);
    }
}
