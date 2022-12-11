<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['namespace' => 'Dashboard'], function() {
        Route::group(['namespace' => 'Pasien'], function() {
            Route::get('/pasien', Biodata::class)->name('pasien');
        });
    });

    Route::group(['namespace' => 'Agen'], function() {
        Route::get('agen', AgenIndex::class)->name('agen');
    });

});
