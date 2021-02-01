<?php
/**PERMISSIONS FOR STUDENTS AWARD */
Route::group(['middleware' => ['auth', 'permission:view-student']], function() {
    Route::get('/user/addAward', 'UserAwardController@index')->name('userStudentAward');
    Route::post('/userawardfilterReport', 'UserAwardController@userawardfilterReport')->name('userawardfilterReport');
    
    Route::get('/user/userAward_dtb', 'UserAwardController@userAward_dtb')->name('userAward_dtb');   
    Route::get('/userAwardDetails/{id}', 'UserAwardController@userAwardDetails')->name('userAwardDetails');
    Route::post('/awardfilterReport', 'AdminAwardController@awardfilterReport')->name('awardfilterReport');
});
Route::group(['middleware' => ['auth', 'permission:create-student']], function() {
    Route::post('/user/addStudentAward', 'UserAwardController@addStudentAward')->name('addStudentAward');
});

Route::group(['middleware' => ['auth', 'permission:delete-student']], function() {
    Route::post('/user/deleteAward', 'UserAwardController@deleteAward')->name('deleteAward');
    Route::post('/user/deleteCert', 'UserAwardController@deleteCert')->name('userDeleteCertAward');
});

Route::group(['middleware' => ['auth', 'permission:edit-student']], function() {
    Route::post('/user/updateStudentAward', 'UserAwardController@updateStudentAward')->name('updateStudentAward');
    Route::get('/userAwardEdit/{id}', 'UserAwardController@userAwardEdit')->name('userAwardEdit');
});

/**PERMISSIONS FOR INSTITUTIONAL AWARDS */
Route::group(['middleware' => ['auth', 'permission:view-instaward']], function() {
    Route::get('/instAward', 'AdminAwardController@instAward')->name('instAward');
    Route::post('/instawardfilterReport', 'AdminAwardController@instawardfilterReport')->name('instawardfilterReport');
    Route::get('/instaward_dtb/{id}', 'AdminAwardController@instaward_dtb')->name('instaward_dtb');
});

Route::group(['middleware' => ['auth', 'permission:create-student']], function() {
    Route::post('/addInstAward', 'AdminAwardController@addInstAward')->name('addInstAward');
});

Route::group(['middleware' => ['auth', 'permission:edit-instaward']], function() {
    Route::get('/instAwardEdit/{id}', 'AdminAwardController@instAwardEdit')->name('instAwardEdit');
    Route::post('/updateInstAward', 'AdminAwardController@updateInstAward')->name('updateInstAward');
});
Route::group(['middleware' => ['auth', 'permission:delete-instaward']], function() {
    Route::post('/deleteInstAward', 'AdminAwardController@deleteInstAward')->name('deleteInstAward');
    
    Route::post('/deleteDocu', 'AdminAwardController@deleteDocu')->name('deleteDocu');
});

/**PERMISSIONS FOR SCHOOL AWARDS */
Route::group(['middleware' => ['auth', 'permission:view-schoolAward']], function() {
    Route::get('/schoolAward', 'SchoolAwardController@schoolAward')->name('schoolAward');
    Route::post('/schoolAwardfilterReport', 'SchoolAwardController@schoolAwardfilterReport')->name('schoolAwardfilterReport');
    Route::get('/schoolAward_dtb/{id}', 'SchoolAwardController@schoolAward_dtb')->name('schoolAward_dtb');
});

Route::group(['middleware' => ['auth', 'permission:create-schoolAward']], function() {
    Route::post('/addSchoolAward', 'SchoolAwardController@addSchoolAward')->name('addSchoolAward');
});

Route::group(['middleware' => ['auth', 'permission:edit-schoolAward']], function() {
    Route::get('/schoolAwardEdit/{id}', 'SchoolAwardController@schoolAwardEdit')->name('schoolAwardEdit');
    Route::post('/updateSchoolAward', 'SchoolAwardController@updateSchoolAward')->name('updateSchoolAward');
});
Route::group(['middleware' => ['auth', 'permission:delete-schoolAward']], function() {
    Route::post('/deleteSchoolAward', 'SchoolAwardController@deleteSchoolAward')->name('deleteSchoolAward');
    Route::post('/deleteDocu', 'SchoolAwardController@deleteDocu')->name('deleteDocu');
});

