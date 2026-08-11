<?php

namespace App\Support;

use App\Models\PageSeo;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

/**
 * Resolves the meta tags for the current request.
 *
 * Precedence, most specific first:
 *   1. the record being shown (a Service and its meta_* columns)
 *   2. the page_seo row matching the current route name
 *   3. the site-wide defaults on the settings row
 *
 * Each step uses HasTranslatedFields::trans(), so an empty Arabic column
 * falls back to its English sibling before dropping to the next step.
 */
class Seo
{
    public const LOCALES = ['en', 'ar'];

    /** Locale codes as Open Graph expects them. */
    private const OG_LOCALES = ['en' => 'en_US', 'ar' => 'ar_AR'];

    public static function resolve(): array
    {
        $settings = Setting::current();
        $page = PageSeo::forRoute(Route::currentRouteName());
        $record = static::currentRecord();

        $title = static::firstFilled([
            $record?->trans('meta_title'),
            $record?->trans('title'),
            $page?->trans('meta_title'),
            $settings->trans('seo_title'),
            $settings->brand_name,
        ]);

        $description = static::firstFilled([
            $record?->trans('meta_description'),
            $record?->trans('short'),
            $page?->trans('meta_description'),
            $settings->trans('seo_description'),
        ]);

        $suffix = $settings->trans('seo_title_suffix');

        // Only append the brand suffix when the resolved title does not already carry it.
        if (filled($suffix) && ! str_contains($title, $suffix)) {
            $title = "{$title} — {$suffix}";
        }

        $image = static::firstFilled([
            $record?->og_image,
            $page?->og_image,
            $settings->og_image,
        ]);

        return [
            'title' => $title,
            'description' => $description,
            'image' => filled($image) ? asset('storage/'.ltrim($image, '/')) : null,
            'noindex' => (bool) ($page?->noindex),
            'canonical' => static::localizedUrl(app()->getLocale()),
            'alternates' => static::alternateUrls(),
            'og_locale' => self::OG_LOCALES[app()->getLocale()] ?? 'en_US',
            'og_locale_alternate' => array_values(array_diff(self::OG_LOCALES, [self::OG_LOCALES[app()->getLocale()] ?? 'en_US'])),
        ];
    }

    /**
     * The same page in every locale, keyed by locale code. Empty when the
     * current route is not locale-prefixed (nothing valid to point at).
     */
    public static function alternateUrls(): array
    {
        $urls = [];

        foreach (self::LOCALES as $locale) {
            $url = static::localizedUrl($locale);

            if ($url !== null) {
                $urls[$locale] = $url;
            }
        }

        return $urls;
    }

    public static function localizedUrl(string $locale): ?string
    {
        $route = Route::current();
        $name = $route?->getName();

        // SetLocale strips the {locale} parameter, so test the route's URI
        // pattern rather than its bound parameters.
        if ($route === null || blank($name) || ! str_contains($route->uri(), '{locale}')) {
            return null;
        }

        return route($name, array_merge($route->parameters(), ['locale' => $locale]));
    }

    /**
     * The model backing the current page, when the route shows a single record.
     */
    private static function currentRecord(): ?Service
    {
        $service = Route::current()?->parameter('service');

        return $service instanceof Service ? $service : null;
    }

    private static function firstFilled(array $candidates): ?string
    {
        foreach ($candidates as $candidate) {
            if (filled($candidate)) {
                return $candidate;
            }
        }

        return null;
    }
}
