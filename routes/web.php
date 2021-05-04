<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    Route::redirect('/', 'admin/home', 302);

    Route::view('home', 'admin.home.index')->name('admin.home');

    Route::resource('dokter', 'Admin\DokterController', ['as' => 'admin']);
    Route::resource('pasien', 'Admin\PasienController', ['as' => 'admin']);
    Route::resource('jadwal', 'Admin\JadwalController', ['as' => 'admin']);
    Route::resource('booking', 'Admin\BookingController', ['as' => 'admin']);
});

Route::group(['prefix' => 'dokter', 'middleware' => ['web', 'dokter']], function () {
    Route::redirect('/', 'dokter/jadwal', 302);

    Route::resource('jadwal', 'Dokter\JadwalController', [
        'only' => ['index', 'show'],
        'as' => 'dokter'
    ]);
});

Route::group(['prefix' => 'pasien', 'middleware' => 'web'], function () {
    Route::redirect('/', 'pasien/home', 302);

    Route::view('home', 'pasien.home.index')->name('pasien.home');

    Route::resource('jadwal', 'Pasien\JadwalController', [
        'only' => ['index', 'show'],
        'as' => 'pasien'
    ]);
    Route::resource('booking', 'Pasien\BookingController', ['as' => 'pasien']);
});
