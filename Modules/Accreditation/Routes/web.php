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
    //reports
    Route::get('/accredReport', 'AccreditationController@accredReport')->name('accredReport');
    Route::post('/filterReport', 'AccreditationController@filterReport')->name('filterReport');
    



    Route::get('/accredDetails/{id}', 'AccreditationController@accredDetails')->name('accredDetails');
    Route::get('/accredEdit/{id}', 'AccreditationController@accredEdit')->name('accredEdit');
    Route::post('/saveEdit', 'AccreditationController@saveEdit')->name('saveEdit');

    //reports
    
    Route::get('/accredHistory/{id}', 'AccreditationController@accredHistory')->name('accredHistory');
    Route::get('/viewPacucoaReport/{id}', 'AccreditationController@viewPacucoaReport')->name('viewPacucoaReport');
    Route::get('/viewProgramHistory', 'AccreditationController@viewProgramHistory')->name('viewProgramHistory');






    //datatables
    Route::get('/school_dtb', 'AccreditationController@school_dtb')->name('school_dtb');
    Route::get('/program_dtb/{id}', 'AccreditationController@program_dtb')->name('program_dtb');
    Route::get('/program_report_dtb', 'AccreditationController@program_report_dtb')->name('program_report_dtb');
    Route::get('/program_history_report_dtb', 'AccreditationController@program_history_report_dtb')->name('program_history_report_dtb');
    Route::get('/history_dtb/{id}', 'AccreditationController@history_dtb')->name('history_dtb');
    Route::get('/accred_stat_dtb', 'AccreditationController@accred_stat_dtb')->name('accred_stat_dtb');



    Route::get('/add_accred_form', 'AccreditationController@add_accred_form')->name('add_accred_form');
    //schools
    Route::post('/school_select', 'AccreditationController@school_select')->name('school_select');
    Route::post('/addSchoolForm', 'AccreditationController@addSchoolForm')->name('addSchoolForm');

    //Add accred
    Route::post('/addAccred', 'AccreditationController@addAccred')->name('addAccred');
    
    Route::get('/accredited_programs/{id}', 'AccreditationController@accredited_programs')->name('accredited_programs');



    //Accred status
    Route::get('/accred_status', 'AccreditationController@accred_status')->name('accred_status');
    //add
    Route::post('/addStatus', 'AccreditationController@addStatus')->name('addStatus');
    Route::post('/deleteStatus', 'AccreditationController@deleteStatus')->name('deleteStatus');
    Route::post('/editStatus', 'AccreditationController@editStatus')->name('editStatus');
    Route::post('/updateStatus', 'AccreditationController@updateStatus')->name('updateStatus');



    

    Route::post('/deleteProg', 'AccreditationController@deleteProg')->name('deleteProg');
    Route::post('/deleteCert', 'AccreditationController@deleteCert')->name('deleteCert');
    Route::post('/addFile', 'AccreditationController@addFile')->name('addFile');


    

});
