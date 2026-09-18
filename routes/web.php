<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/suites', 'suites')->name('suites');
Route::view('/amenities', 'amenities')->name('amenities');
Route::view('/offers', 'offers')->name('offers');
Route::view('/local-area', 'local-area')->name('local-area');
Route::view('/photos', 'photos')->name('photos');
Route::view('/groups', 'groups')->name('groups');
Route::view('/contact', 'contact')->name('contact');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/refund-policy', 'refund')->name('refund');

Route::get('/booking', [BookingController::class, 'show'])->name('booking');
Route::get('/pay', [BookingController::class, 'pay'])->name('pay');

Route::post('/api/create-payment-intent', [BookingController::class, 'createIntent'])
    ->middleware('throttle:10,1')
    ->name('api.createIntent');
Route::get('/api/confirm-booking', [BookingController::class, 'confirm'])
    ->middleware('throttle:30,1')
    ->name('api.confirmBooking');
Route::post('/api/stripe/webhook', [BookingController::class, 'webhook'])
    ->name('api.stripe.webhook');
Route::post('/api/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('api.contact');

Route::any('/api/admin/bookings', [AdminController::class, 'bookings'])
    ->middleware('throttle:20,1')
    ->name('admin.bookings');
Route::get('/admin', fn () => view('admin'))->name('admin');

Route::get('/robots.txt', function () {
    $lines = [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin',
        'Disallow: /api/',
        'Disallow: /pay',
        '',
        'Sitemap: '.url('/sitemap.xml'),
    ];

    return response(implode("\n", $lines), 200)->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/sitemap.xml', function () {
    $pages = [
        ['home', '1.0', 'weekly'],
        ['suites', '0.9', 'weekly'],
        ['amenities', '0.8', 'monthly'],
        ['offers', '0.8', 'weekly'],
        ['local-area', '0.6', 'monthly'],
        ['photos', '0.6', 'monthly'],
        ['groups', '0.7', 'monthly'],
        ['contact', '0.6', 'monthly'],
        ['booking', '0.9', 'weekly'],
    ];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
    foreach ($pages as [$name, $priority, $frequency]) {
        $xml .= '    <url>';
        $xml .= '<loc>'.e(route($name)).'</loc>';
        $xml .= '<changefreq>'.$frequency.'</changefreq>';
        $xml .= '<priority>'.$priority.'</priority>';
        $xml .= '</url>'."\n";
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');
