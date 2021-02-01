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
//Route::group(['prefix' => 'award', 'middleware' => 'is_admin'], function() {
    Route::group(['middleware' => 'permission:view-student'], function() {
        Route::get('/user/addAward', 'UserAwardController@index')->name('userStudentAward');
    
        Route::get('/viewAward', 'AdminAwardController@index')->name('viewStudentAward');
        Route::post('/awardfilterReport', 'AdminAwardController@awardfilterReport')->name('awardfilterReport');
        Route::post('/instawardfilterReport', 'AdminAwardController@instawardfilterReport')->name('instawardfilterReport');
        Route::post('/awardExcelReport', 'AdminAwardController@awardExcelReport')->name('awardExcelReport');
        Route::get('/award_dtb/{id}', 'AdminAwardController@award_dtb')->name('award_dtb');
    
        Route::get('/user/userAward_dtb', 'UserAwardController@userAward_dtb')->name('userAward_dtb');
        Route::post('/userawardfilterReport', 'UserAwardController@userawardfilterReport')->name('userawardfilterReport');
        Route::get('/userAwardDetails/{id}', 'UserAwardController@userAwardDetails')->name('userAwardDetails');
    });
    Route::group(['middleware' => 'permission:edit-student'], function() {
        Route::post('/user/updateStudentAward', 'UserAwardController@updateStudentAward')->name('updateStudentAward');
        Route::get('/userAwardEdit/{id}', 'UserAwardController@userAwardEdit')->name('userAwardEdit');
    });
    
    Route::group(['middleware' => 'permission:delete-student'], function() {
        Route::post('/user/deleteAward', 'UserAwardController@deleteAward')->name('deleteAward');
        Route::post('/user/deleteCert', 'UserAwardController@deleteCert')->name('userDeleteCertAward');
    });
    
    
    Route::group(['middleware' => 'permission:create-student'], function() {
        Route::post('/user/addStudentAward', 'UserAwardController@addStudentAward')->name('addStudentAward');
    });
    
    /**PERMISSIONS FOR INSTITUTIONAL AWARD */
    
    Route::group(['middleware' => 'permission:view-instaward'], function() {
        Route::get('/instAward', 'AdminAwardController@instAward')->name('instAward');
        Route::get('/instaward_dtb/{id}', 'AdminAwardController@instaward_dtb')->name('instaward_dtb');
    });
    
    Route::group(['middleware' => 'permission:edit-instaward'], function() {
        Route::get('/instAwardEdit/{id}', 'AdminAwardController@instAwardEdit')->name('instAwardEdit');
        Route::post('/updateInstAward', 'AdminAwardController@updateInstAward')->name('updateInstAward');
    });
    
    Route::group(['middleware' => 'permission:delete-student'], function() {
        Route::post('/deleteDocu', 'AdminAwardController@deleteDocu')->name('deleteDocu');
        Route::post('/deleteInstAward', 'AdminAwardController@deleteInstAward')->name('deleteInstAward');
    });
    
    Route::group(['middleware' => 'permission:create-student'], function() {
        Route::post('/addInstAward', 'AdminAwardController@addInstAward')->name('addInstAward');
    });


Route::group(['prefix' => 'award'], function() {
    Route::get('/', 'AwardController@index');
    // DATA TABLES
    
    Route::get('/viewAward', 'AdminAwardController@index')->name('viewStudentAward');
    Route::post('/awardfilterReport', 'AdminAwardController@awardfilterReport')->name('awardfilterReport');
    Route::post('/instawardfilterReport', 'AdminAwardController@instawardfilterReport')->name('instawardfilterReport');
    Route::post('/awardExcelReport', 'AdminAwardController@awardExcelReport')->name('awardExcelReport');
    Route::get('/award_dtb/{id}', 'AdminAwardController@award_dtb')->name('award_dtb');

    //Institutional Award
    Route::get('/instAward', 'AdminAwardController@instAward')->name('instAward');
    Route::get('/instaward_dtb/{id}', 'AdminAwardController@instaward_dtb')->name('instaward_dtb');
    Route::post('/addInstAward', 'AdminAwardController@addInstAward')->name('addInstAward');
    Route::get('/instAwardEdit/{id}', 'AdminAwardController@instAwardEdit')->name('instAwardEdit');
    Route::post('/updateInstAward', 'AdminAwardController@updateInstAward')->name('updateInstAward');
     Route::post('/deleteDocu', 'AdminAwardController@deleteDocu')->name('deleteDocu');
     Route::post('/deleteInstAward', 'AdminAwardController@deleteInstAward')->name('deleteInstAward');
    

	Route::get('/user/userAward_dtb', 'UserAwardController@userAward_dtb')->name('userAward_dtb');

    Route::post('/user/addStudentAward', 'UserAwardController@addStudentAward')->name('addStudentAward');
    Route::post('/user/updateStudentAward', 'UserAwardController@updateStudentAward')->name('updateStudentAward');
    Route::get('/user/addAward', 'UserAwardController@index')->name('userStudentAward');
    Route::post('/userawardfilterReport', 'UserAwardController@userawardfilterReport')->name('userawardfilterReport');
    Route::get('/userAwardDetails/{id}', 'UserAwardController@userAwardDetails')->name('userAwardDetails');
    Route::get('/userAwardEdit/{id}', 'UserAwardController@userAwardEdit')->name('userAwardEdit');
    Route::post('/user/deleteAward', 'UserAwardController@deleteAward')->name('deleteAward');
    Route::post('/user/deleteCert', 'UserAwardController@deleteCert')->name('userDeleteCertAward');
});

// ***** ROUTES FOR QA ******
