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

    /** The language served from the bare path, with no prefix in the URL. */
    public const DEFAULT_LOCALE = 'en';

    /**
     * Route name for a page in a given language. Arabic routes carry an
     * "ar." prefix; the default language uses the bare name.
     */
    public static function routeNameFor(string $name, string $locale): string
    {
        $name = static::unlocalizedRouteName($name) ?? $name;

        return $locale === self::DEFAULT_LOCALE ? $name : "{$locale}.{$name}";
    }

    /**
     * Strips the locale prefix from a route name: "ar.about" becomes "about".
     * Returns null for routes outside the localized groups.
     */
    public static function unlocalizedRouteName(?string $name): ?string
    {
        if (blank($name)) {
            return null;
        }

        foreach (self::LOCALES as $locale) {
            if (str_starts_with($name, "{$locale}.")) {
                return substr($name, strlen($locale) + 1);
            }
        }

        return $name;
    }

    /** The language a route name belongs to. */
    public static function localeForRouteName(?string $name): string
    {
        foreach (self::LOCALES as $locale) {
            if ($locale !== self::DEFAULT_LOCALE && str_starts_with((string) $name, "{$locale}.")) {
                return $locale;
            }
        }

        return self::DEFAULT_LOCALE;
    }

    /** Locale codes as Open Graph expects them. */
    private const OG_LOCALES = ['en' => 'en_US', 'ar' => 'ar_AR'];

    public static function resolve(): array
    {
        $settings = Setting::current();
        // page_seo rows are keyed by the bare name, shared across languages.
        $page = PageSeo::forRoute(static::unlocalizedRouteName(Route::currentRouteName()));
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

        if ($route === null || ! static::isLocalizedRouteName($name)) {
            return null;
        }

        return route(static::routeNameFor($name, $locale), $route->parameters());
    }

    /**
     * True for the public pages that exist in both languages. Routes like the
     * sitemap or the locale switcher have no alternate to point at.
     */
    public static function isLocalizedRouteName(?string $name): bool
    {
        if (blank($name)) {
            return false;
        }

        return Route::has(static::routeNameFor($name, self::DEFAULT_LOCALE))
            && Route::has(static::routeNameFor($name, 'ar'));
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
