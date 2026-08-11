<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TeamController;
use App\Support\Seo;
use Illuminate\Support\Facades\Route;

/*
 * Every public page lives under a locale prefix (/en/..., /ar/...) so each
 * language has its own indexable URL and hreflang has something to point at.
 * SetLocale reads the prefix and registers it as a URL default, which is why
 * route('about') in a view still works without passing the locale by hand.
 */
Route::prefix('{locale}')
    ->whereIn('locale', Seo::LOCALES)
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/about', [AboutController::class, 'index'])->name('about');
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
        Route::get('/team', [TeamController::class, 'index'])->name('team');
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    });

Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

/*
 * Legacy unprefixed URLs keep working: /about redirects to /en/about, or to
 * the visitor's remembered locale. See LocaleController::redirectToLocalized
 * for why these are 302 and not 301.
 */
Route::get('/', [LocaleController::class, 'redirectToLocalized'])->name('root');
Route::get('/{path}', [LocaleController::class, 'redirectToLocalized'])
    ->where('path', 'about|services|team|contact');
Route::get('/services/{service}', [LocaleController::class, 'redirectToLocalized']);
