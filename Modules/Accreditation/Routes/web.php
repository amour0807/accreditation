<?php
/* ALLOWED FOR VIEWING*/
Route::group(['middleware' =>  ['auth', 'permission:view-accred']], function() {
    Route::get('/adminAcred_prog', 'AccreditationController@adminAcred_prog')->name('adminAcred_prog');
    Route::get('/accred_status', 'AccreditationController@accred_status')->name('accred_status');
    Route::get('/viewSchool', 'AccreditationController@viewSchool')->name('viewSchool');
    Route::get('/academic_programs', 'AccreditationController@academic_programs')->name('academic_programs');
    Route::get('/accredReport', 'AccreditationController@accredReport')->name('accredReport');
    Route::get('/viewProgramHistory', 'AccreditationController@viewProgramHistory')->name('viewProgramHistory');
    Route::get('/accredDetails/{id}', 'AccreditationController@accredDetails')->name('accredDetails');
    Route::get('/accredHistory/{id}', 'AccreditationController@accredHistory')->name('accredHistory');
    Route::get('/accred_stat_dtb', 'AccreditationController@accred_stat_dtb')->name('accred_stat_dtb');
    Route::get('/school_dept_dtb', 'AccreditationController@school_dept_dtb')->name('school_dept_dtb');
    Route::post('/filterReport', 'AccreditationController@filterReport')->name('filterReport');
    Route::get('/program_report_dtb', 'AccreditationController@program_report_dtb')->name('program_report_dtb');
    Route::get('/program_history_report_dtb', 'AccreditationController@program_history_report_dtb')->name('program_history_report_dtb');
    Route::get('/history_dtb/{id}', 'AccreditationController@history_dtb')->name('history_dtb');
    Route::get('/school_dtb', 'AccreditationController@school_dtb')->name('school_dtb');
    Route::post('/acadprogReport', 'AccreditationController@acadprogReport')->name('acadprogReport');
 });

 Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::get('/accounts', '\Modules\User\Http\Controllers\UserController@index')->name('accounts');
    
 });
 
 Route::get('/accredIndex', 'AccreditationController@index')->name('accredIndex')->middleware('auth');

 /* ALLOWED FOR CREATING*/
 Route::group(['middleware' => ['auth', 'permission:create-accred']], function() {
    Route::get('/add_accred_form', 'AccreditationController@add_accred_form')->name('add_accred_form');
    Route::post('/addSchoolForm', 'AccreditationController@addSchoolForm')->name('addSchoolForm');
    Route::post('/addFile', 'AccreditationController@addFile')->name('addFile');
    Route::post('/addAccred', 'AccreditationController@addAccred')->name('addAccred');
    Route::post('/school_select', 'AccreditationController@school_select')->name('school_select');
    Route::post('/addSchoolForm', 'AccreditationController@addSchoolForm')->name('addSchoolForm');
    Route::post('/addStatus', 'AccreditationController@addStatus')->name('addStatus');
    Route::post('/addAcadProg', 'AccreditationController@addAcadProg')->name('addAcadProg');
    Route::get('/acadprogram_dtb', 'AccreditationController@acadprogram_dtb')->name('acadprogram_dtb');
 });

 /* ALLOWED FOR EDITING*/
 Route::group(['middleware' => ['auth', 'permission:edit-accred']], function() {
    Route::get('/accredEdit/{id}', 'AccreditationController@accredEdit')->name('accredEdit');
    Route::post('/saveEdit', 'AccreditationController@saveEdit')->name('saveEdit');
    Route::post('/editStatus', 'AccreditationController@editStatus')->name('editStatus');
    Route::post('/updateStatus', 'AccreditationController@updateStatus')->name('updateStatus'); 
    Route::post('/editSchoolDept', 'AccreditationController@editSchoolDept')->name('editSchoolDept');
    Route::post('/updateSchoolDept', 'AccreditationController@updateSchoolDept')->name('updateSchoolDept'); 
    Route::post('/editAcadProg', 'AccreditationController@editAcadProg')->name('editAcadProg');
    Route::post('/updateAcadProg', 'AccreditationController@updateAcadProg')->name('updateAcadProg');
 });

 /* ALLOWED FOR DELETING*/
 Route::group(['middleware' => ['auth', 'permission:delete-accred']], function() {
    Route::post('/deleteCert', 'AccreditationController@deleteCert')->name('deleteCert');
    Route::post('/deleteStatus', 'AccreditationController@deleteStatus')->name('deleteStatus');
    Route::post('/deleteSchoolDept', 'AccreditationController@deleteSchool')->name('deleteSchoolDept');
    Route::post('/user/deleteCert', 'UserAccreditationController@deleteCert')->name('userDeleteCert');
    Route::post('/deleteAcadProg', 'AccreditationController@deleteAcadProg')->name('deleteAcadProg');
    Route::post('/deleteProg', 'AccreditationController@deleteProg')->name('deleteProg');
 });
 





