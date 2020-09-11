<?php

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

Route::prefix('accreditation')->group(function() {
    Route::get('/', 'AccreditationController@index');

    Route::get('/school_dtb', 'AccreditationController@school_dtb')->name('school_dtb');



});
