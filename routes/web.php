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
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/staff', 'Auth\LoginController@staffLogin')->name('staff');
Route::get('/alumni', 'Auth\LoginController@alumniLogin')->name('alumni');

Route::get('/logout', function () {
    return view('auth.logout');
});

