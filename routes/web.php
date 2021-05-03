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

    Route::get('booking/slot-jadwal/{id}', 'BookingController@slotJadwal')->name('admin.booking.slotJadwal');
    Route::get('booking/dokter-service/{id}', 'BookingController@dokterServiceJadwal')->name('admin.booking.dokterService');

    Route::resource('dokter', 'DokterController', ['as' => 'admin']);
    Route::resource('pasien', 'PasienController', ['as' => 'admin']);
    Route::resource('jadwal', 'JadwalController', ['as' => 'admin']);
    Route::resource('booking', 'BookingController', ['as' => 'admin']);
});

Route::group(['prefix' => 'dokter', 'middleware' => ['web', 'dokter']], function () {
    Route::redirect('/', 'dokter/jadwal', 302);
    Route::resource('jadwal', 'JadwalController', ['as' => 'dokter']);
});

Route::group(['prefix' => 'pasien', 'middleware' => 'web'], function () {
    Route::redirect('/', 'pasien/home', 302);
    Route::view('home', 'pasien.home.index')->name('pasien.home');
    Route::get('booking/slot-jadwal/{id}', 'BookingController@slotJadwal')->name('pasien.booking.slotJadwal');
    Route::get('booking/dokter-service/{id}', 'BookingController@dokterServiceJadwal')->name('pasien.booking.dokterService');

    Route::resource('dokter', 'DokterController', ['as' => 'pasien']);
    Route::resource('pasien', 'PasienController', ['as' => 'pasien']);
    Route::resource('jadwal', 'JadwalController', ['as' => 'pasien']);
    Route::resource('booking', 'BookingController', ['as' => 'pasien']);
});

Route::view('/home', 'home');
