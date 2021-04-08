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
    Route::resource('dokter', 'DokterController', ['as' => 'admin']);
    Route::resource('jadwal', 'JadwalController', ['as' => 'admin']);
    Route::get('booking', 'BookingController@indexAdmin')->name('admin.booking.index');
    Route::resource('booking', 'BookingController', ['as' => 'admin'])->except(['index']);
});

Route::view('/home', 'home');
