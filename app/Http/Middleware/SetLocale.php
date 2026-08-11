<?php

namespace App\Http\Middleware;

use App\Support\Seo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // The URL is authoritative: an "ar."-prefixed route name means the
        // visitor asked for Arabic, anything else is English. Nothing is
        // inferred from the session, so a given URL always renders the same
        // language for every visitor and for crawlers.
        $locale = Seo::localeForRouteName($request->route()?->getName());

        app()->setLocale($locale);

        return $next($request);
    }

}
