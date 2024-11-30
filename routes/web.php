<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::view('dashboard', 'dashboard')
    ->name('dashboard');

Route::view('about-us', 'about-us')->name('about-us');
Route::view('tourist-spots', 'tourist-spots')->name('tourist-spots');
Route::view('hotel-resorts', 'hotel-resorts')->name('hotel-resorts');
Route::view('restaurants', 'restaurants')->name('restaurants');
Route::view('news-events', 'news-events')->name('news-events');
Route::view('contact-us', 'contact-us')->name('contact-us');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
