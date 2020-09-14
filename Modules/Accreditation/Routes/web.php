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
    Route::get('/', 'AccreditationController@index')->name('accredIndex');
    Route::get('/accredReport', 'AccreditationController@accredReport')->name('accredReport');


    //datatables
    Route::get('/school_dtb', 'AccreditationController@school_dtb')->name('school_dtb');
    Route::get('/program_dtb/{id}', 'AccreditationController@program_dtb')->name('program_dtb');
    Route::get('/program_report_dtb', 'AccreditationController@program_report_dtb')->name('program_report_dtb');



    Route::get('/add_accred_form', 'AccreditationController@add_accred_form')->name('add_accred_form');
    //schools
    Route::post('/school_select', 'AccreditationController@school_select')->name('school_select');
    Route::post('/addSchoolForm', 'AccreditationController@addSchoolForm')->name('addSchoolForm');

    //Add accred
    Route::post('/addAccred', 'AccreditationController@addAccred')->name('addAccred');
    
    Route::get('/accredited_programs/{id}', 'AccreditationController@accredited_programs')->name('accredited_programs');




});
