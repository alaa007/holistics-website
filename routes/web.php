<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
 * English is the default language and lives at the bare path (/about);
 * Arabic is prefixed (/ar/about).
 *
 * The same routes are registered twice from one closure. The Arabic copy
 * carries an "ar." name prefix, so every page has two distinct route names —
 * "about" and "ar.about" — and each language has its own real, indexable URL.
 *
 * Views do not call route() directly for these; localized_route() in
 * app/Support/helpers.php picks the right name for the active locale.
 * Duplicate route names were tried first and rejected: which of the two a
 * name resolves to is unspecified behaviour.
 */
$localizedRoutes = function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/team', [TeamController::class, 'index'])->name('team');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
};

Route::group([], $localizedRoutes);
Route::prefix('ar')->name('ar.')->group($localizedRoutes);

Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

/*
 * The /en/... URLs this site briefly used redirect to their bare equivalents.
 * Permanent, because the target is a fixed function of the path rather than
 * something negotiated per visitor, so caching it cannot pin the wrong
 * language onto a URL.
 */
Route::redirect('/en', '/', 301);
Route::get('/en/{path}', [LocaleController::class, 'redirectFromEnglishPrefix'])
    ->where('path', '.*');
