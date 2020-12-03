<?php


// ***** ROUTES FOR THE OTHER USER (SCHOOLS) *****

Route::group(['prefix' => 'user-accreditation', 'middleware' => 'is_guest'], function() {

    Route::get('/user/', 'UserAccreditationController@index')->name('userAccredIndex');
    Route::get('/user/acred_prog', 'UserAccreditationController@acred_prog')->name('acred_prog');
    //reports
    Route::get('/user/accredReport', 'UserAccreditationController@accredReport')->name('userAccredReport');
    Route::post('/user/filterReport', 'UserAccreditationController@filterReport')->name('userFilterReport');


    Route::get('/user/accredDetails/{id}', 'UserAccreditationController@accredDetails')->name('userAccredDetails');
    Route::get('/user/accredEdit/{id}', 'UserAccreditationController@accredEdit')->name('userAccredEdit');
    Route::post('/user/saveEdit', 'UserAccreditationController@saveEdit')->name('userSaveEdit');

    //reports
    
    Route::get('/user/accredHistory/{id}', 'UserAccreditationController@accredHistory')->name('userAccredHistory');
    Route::get('/user/viewPacucoaReport/{id}', 'UserAccreditationController@viewPacucoaReport')->name('userViewPacucoaReport');
    Route::get('/user/viewProgramHistory', 'UserAccreditationController@viewProgramHistory')->name('userViewProgramHistory');



    //datatables
    Route::get('/user/school_dtb', 'UserAccreditationController@school_dtb')->name('userSchool_dtb');
    Route::get('/user/program_dtb/{id}', 'UserAccreditationController@program_dtb')->name('userProgram_dtb');
    Route::get('/user/userAward_dtb/{id}', 'UserAwardController@userAward_dtb')->name('userAward_dtb');
     Route::get('/user/userAcadprog_dtb/{id}', 'UserAccreditationController@userAcadprog_dtb')->name('userAcadprog_dtb');
    Route::get('/user/program_report_dtb', 'UserAccreditationController@program_report_dtb')->name('userProgram_report_dtb');
    Route::get('/user/program_history_report_dtb', 'UserAccreditationController@program_history_report_dtb')->name('userProgram_history_report_dtb');
    Route::get('/user/history_dtb/{id}', 'UserAccreditationController@history_dtb')->name('userHistory_dtb');
    Route::get('/user/accred_stat_dtb', 'UserAccreditationController@accred_stat_dtb')->name('userAccred_stat_dtb');


    Route::get('/user/add_accred_form', 'UserAccreditationController@add_accred_form')->name('userAdd_accred_form');
    //schools
    Route::post('/user/addSchoolForm', 'UserAccreditationController@addSchoolForm')->name('userAddSchoolForm');
    Route::post('/user/addStudentAward', 'UserAwardController@addStudentAward')->name('addStudentAward');
    //Add accred
    Route::post('/user/addAccred', 'UserAccreditationController@addAccred')->name('userAddAccred');
    
    Route::get('/user/accredited_programs/{id}', 'UserAccreditationController@accredited_programs')->name('userAccredited_programs');

    //Accred 
    Route::get('/user/accred_status', 'UserAccreditationController@accred_status')->name('userAccred_status');
    //add
    Route::post('/user/addStatus', 'UserAccreditationController@addStatus')->name('userAddStatus');
    Route::post('/user/deleteStatus', 'UserAccreditationController@deleteStatus')->name('userDeleteStatus');
    Route::post('/user/editStatus', 'UserAccreditationController@editStatus')->name('usereditStatus');
    Route::post('/user/updateStatus', 'UserAccreditationController@updateStatus')->name('userupdateStatus');
    
    Route::post('/updateStudentAward', 'UserAwardController@updateStudentAward')->name('updateStudentAward');
    Route::post('/user/deleteProg', 'UserAccreditationController@deleteProg')->name('userDeleteProg');
    Route::post('/user/deleteCert', 'UserAccreditationController@deleteCert')->name('userDeleteCert');
    Route::post('/user/addFile', 'UserAccreditationController@addFile')->name('userAddFile');
    Route::get('/user/userAcadprogram_dtb/{id}', 'UserAccreditationController@userAcadprogram_dtb')->name('userAcadprogram_dtb');

// ***** ROUTES FOR ACADEMIC PROGRAMS (SCHOOLS) *****
    Route::get('/user/addAward', '\Modules\Award\Http\Controllers\UserAwardController@index')->name('userStudentAward');
   
    Route::get('/user/userAcademic_programs', 'UserAccreditationController@userAcademic_programs')->name('userAcademic_programs');
    Route::post('/user/useraddAcadProg', 'UserAccreditationController@useraddAcadProg')->name('useraddAcadProg');

    Route::post('/changePassword','UserAccreditationController@changePassword')->name('changePassword');
});

// ***** ROUTES FOR THE QA ******

Route::group(['prefix' => 'accreditation', 'middleware' => 'is_admin'], function() {
    Route::get('/', 'AccreditationController@index')->name('accredIndex');
    Route::get('/adminAcred_prog', 'AccreditationController@adminAcred_prog')->name('adminAcred_prog');
    //reports
    Route::get('/accredReport', 'AccreditationController@accredReport')->name('accredReport');
    Route::post('/filterReport', 'AccreditationController@filterReport')->name('filterReport');
    
    Route::get('/viewSchool', 'AccreditationController@viewSchool')->name('viewSchool');

    Route::get('/accredDetails/{id}', 'AccreditationController@accredDetails')->name('accredDetails');
    Route::get('/accredEdit/{id}', 'AccreditationController@accredEdit')->name('accredEdit');
    Route::post('/saveEdit', 'AccreditationController@saveEdit')->name('saveEdit');
    Route::get('/academic_programs', 'AccreditationController@academic_programs')->name('academic_programs');

    //reports
    
    Route::get('/accredHistory/{id}', 'AccreditationController@accredHistory')->name('accredHistory');
    Route::get('/viewPacucoaReport/{id}', 'AccreditationController@viewPacucoaReport')->name('viewPacucoaReport');
    Route::get('/viewProgramHistory', 'AccreditationController@viewProgramHistory')->name('viewProgramHistory');

    Route::get('/acadProgDetails/{id}', 'AccreditationController@acadProgDetails')->name('acadProgDetails');

    //datatables
    Route::get('/school_dtb', 'AccreditationController@school_dtb')->name('school_dtb');
    Route::get('/program_dtb/{id}', 'AccreditationController@program_dtb')->name('program_dtb');

    Route::get('/acadprogram_dtb', 'AccreditationController@acadprogram_dtb')->name('acadprogram_dtb');
    
    Route::get('/program_report_dtb', 'AccreditationController@program_report_dtb')->name('program_report_dtb');
    Route::get('/program_history_report_dtb', 'AccreditationController@program_history_report_dtb')->name('program_history_report_dtb');
    Route::get('/history_dtb/{id}', 'AccreditationController@history_dtb')->name('history_dtb');
    Route::get('/accred_stat_dtb', 'AccreditationController@accred_stat_dtb')->name('accred_stat_dtb');
    Route::get('/school_dept_dtb', 'AccreditationController@school_dept_dtb')->name('school_dept_dtb');
     Route::get('/acad_prog_dtb', 'AccreditationController@acad_prog_dtb')->name('acad_prog_dtb');

    //schools
    Route::post('/school_select', 'AccreditationController@school_select')->name('school_select');
    Route::post('/addSchoolForm', 'AccreditationController@addSchoolForm')->name('addSchoolForm');
   
    Route::post('/addAcadProg', 'AccreditationController@addAcadProg')->name('addAcadProg');


    //Accred
    Route::post('/addAccred', 'AccreditationController@addAccred')->name('addAccred');
    
    Route::get('/accredited_programs/{id}', 'AccreditationController@accredited_programs')->name('accredited_programs');

    Route::get('/add_accred_form', 'AccreditationController@add_accred_form')->name('add_accred_form');


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

    //ACCOUNTS
    Route::post('/accounts', '\Modules\User\Http\Controllers\UserController@index')->name('accounts');


    Route::post('/editSchoolDept', 'AccreditationController@editSchoolDept')->name('editSchoolDept');
    
    Route::post('/updateSchoolDept', 'AccreditationController@updateSchoolDept')->name('updateSchoolDept');
    Route::post('/deleteSchoolDept', 'AccreditationController@deleteSchool')->name('deleteSchoolDept');

    //ACADEMIC PROGRAMS
    Route::post('/editAcadProg', 'AccreditationController@editAcadProg')->name('editAcadProg');
    Route::post('/updateAcadProg', 'AccreditationController@updateAcadProg')->name('updateAcadProg');
    Route::post('/deleteAcadProg', 'AccreditationController@deleteAcadProg')->name('deleteAcadProg');

    //AWARDS
    Route::get('/award_dtb/{id}', 'AdminAwardController@award_dtb')->name('award_dtb');
    Route::get('/viewAward', '\Modules\Award\Http\Controllers\AdminAwardController@index')->name('viewStudentAward');
});



