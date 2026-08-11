<?php

namespace App\Http\Controllers;

use App\Models\PageSeo;
use App\Models\Service;
use App\Support\Seo;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /** Routes with no record behind them, in rough order of importance. */
    private const STATIC_ROUTES = ['home', 'about', 'services.index', 'team', 'contact'];

    /**
     * Served from a route rather than public/robots.txt so the Sitemap line
     * always carries the current environment's own domain.
     */
    public function robots(): Response
    {
        $body = "User-agent: *\nDisallow:\n\nSitemap: ".route('sitemap')."\n";

        return response($body)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function index(): Response
    {
        $noindex = PageSeo::query()->where('noindex', true)->pluck('route_name')->all();

        $entries = [];

        foreach (self::STATIC_ROUTES as $routeName) {
            if (in_array($routeName, $noindex, true)) {
                continue;
            }

            $entries[] = [
                'urls' => $this->localizedUrls($routeName),
                'lastmod' => null,
            ];
        }

        if (! in_array('services.show', $noindex, true)) {
            foreach (Service::active()->get() as $service) {
                $entries[] = [
                    'urls' => $this->localizedUrls('services.show', ['service' => $service->slug]),
                    'lastmod' => $service->updated_at?->toAtomString(),
                ];
            }
        }

        return response()
            ->view('sitemap', ['entries' => $entries])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * The same page in every locale. Each entry is emitted as its own <url>
     * carrying the full alternate set, which is what Google expects for a
     * multilingual sitemap.
     *
     * @return array<string, string>
     */
    private function localizedUrls(string $routeName, array $parameters = []): array
    {
        $urls = [];

        foreach (Seo::LOCALES as $locale) {
            $urls[$locale] = route($routeName, array_merge($parameters, ['locale' => $locale]));
        }

        return $urls;
    }
}
