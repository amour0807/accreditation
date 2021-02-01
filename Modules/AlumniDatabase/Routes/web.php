<?php

Route::group(['middleware' => ['is_admin']], function() {
    Route::get('/secretary', 'AlumniController@graduateindex')->name('secretary');
    Route::get('/graduateindex', 'AlumniController@graduateindex')->name('graduateindex');
    Route::get('/userAccounts', 'AlumniController@userAccount')->name('userAccounts');
   
    /***** GRADUATE ROUTE ***************/
    Route::post('/addAlumniGraduate', 'AlumniGraduateController@addGraduate')->name('addAlumniGraduate');
    Route::post('/addAlumniAccount', 'AlumniGraduateController@addAccount')->name('addAlumniAccount');
    Route::post('/alumniGradfilterReport', 'AlumniGraduateController@graduatefilterReport')->name('alumniGradfilterReport');
    Route::post('/alumniGraduate_select', 'AlumniGraduateController@graduate_select')->name('alumniGraduate_select');
    Route::get('/alumniGraduateEdit/{id}', 'AlumniGraduateController@graduateEdit')->name('alumniGraduateEdit');
    Route::post('/alumniAccountEdit', 'AlumniGraduateController@accountEdit')->name('alumniAccountEdit');
    Route::post('/updateAccount', 'AlumniGraduateController@updateAccount')->name('updateAccount'); 
    Route::post('/alumniUpdateGraduate', 'AlumniGraduateController@updateGraduate')->name('alumniUpdateGraduate');
    Route::get('/alumniGraduate_dtb', 'AlumniGraduateController@graduate_dtb')->name('alumniGraduate_dtb');
    Route::get('/useraccount_dtb', 'AlumniGraduateController@useraccount_dtb')->name('useraccount_dtb');
    Route::post('/deleteAlumniGraduate', 'AlumniGraduateController@deleteGraduate')->name('deleteAlumniGraduate');
    
    /******* REPORT ROUTE **************/
    Route::get('/report', 'ReportController@index')->name('report');
    Route::get('/report_dtb', 'ReportController@report_dtb')->name('report_dtb');
    Route::post('/reportfilterReport', 'ReportController@reportfilterReport')->name('reportfilterReport');Route::post('reportschool_select','ReportController@school_select')->name('reportschool_select');
    /******* IMPORT EXCEL **************/
    Route::post('/alumniImport','AlumniImportController@store')->name('alumniImport');
    
    /** SECRETARY */
    Route::get('/firstloginAlumni', 'AlumniController@firstloginAlumni')->name('firstloginAlumni');
    Route::post('/changeAlumniPassword','AlumniController@changePassword')->name('changeAlumniPassword');
});

Route::group(['middleware' => ['is_guest']], function() {
    Route::get('/alumniGraduate', 'AlumniGraduateController@index')->name('alumniGraduate');
    Route::post('/addSurvey', 'SurveyController@addSurvey')->name('addSurvey');
});

Route::get('/sendbasicemail/{email}','MailController@basic_email')->name('sendbasicemail');

