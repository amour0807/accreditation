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

/**PERMISSIONS FOR NUMBER OF EMPLOYEES */
Route::group(['middleware' => ['auth', 'permission:view-employees']], function() {
    Route::get('/hrInput', 'QuantitativeReportController@index')->name('hrInput');
    Route::get('/employee_dtb', 'QuantitativeReportController@employee_dtb')->name('employee_dtb');
    Route::post('/employeefilterReport', 'QuantitativeReportController@employeefilterReport')->name('employeefilterReport');
});
Route::group(['middleware' => ['auth', 'permission:create-employees']], function() {
    Route::post('/addEmployee', 'QuantitativeReportController@addEmployee')->name('addEmployee');
});

Route::group(['middleware' => ['auth', 'permission:edit-employees']], function() {
    Route::post('/updateEmployee', 'QuantitativeReportController@updateEmployee')->name('updateEmployee');
    Route::get('/employeeEdit/{id}', 'QuantitativeReportController@employeeEdit')->name('employeeEdit');
});

Route::group(['middleware' => ['auth', 'permission:delete-employees']], function() {
    Route::post('/deleteEmployee', 'QuantitativeReportController@deleteEmployee')->name('deleteEmployee');
});

/**PERMISSIONS FOR NUMBER OF ENROLLMENT */
Route::group(['middleware' => ['auth', 'permission:view-enrollment']], function() {
    Route::get('/enrollment', 'EnrollmentController@index')->name('enrollment');
    Route::get('/enrollment_dtb', 'EnrollmentController@enrollment_dtb')->name('enrollment_dtb');
    Route::post('/enrollmentfilterReport', 'EnrollmentController@enrollmentfilterReport')->name('enrollmentfilterReport');
});
Route::group(['middleware' => ['auth', 'permission:create-enrollment']], function() {
    Route::post('/addEnrollment', 'EnrollmentController@addEnrollment')->name('addEnrollment');
    Route::post('/enrollment_select', 'EnrollmentController@enrollment_select')->name('enrollment_select');
});

Route::group(['middleware' => ['auth', 'permission:edit-enrollment']], function() {
    Route::post('/updateEnrollment', 'EnrollmentController@updateEnrollment')->name('updateEnrollment');
    Route::get('/enrollmentEdit/{id}', 'EnrollmentController@enrollmentEdit')->name('enrollmentEdit');
});

Route::group(['middleware' => ['auth', 'permission:delete-enrollment']], function() {
    Route::post('/deleteEnrollment', 'EnrollmentController@deleteEnrollment')->name('deleteEnrollment');
});

/**PERMISSIONS FOR NUMBER OF GRADUATE */
Route::group(['middleware' => ['auth', 'permission:view-graduate']], function() {
    Route::get('/graduate', 'GraduateController@index')->name('graduate');
    Route::get('/graduate_dtb', 'GraduateController@graduate_dtb')->name('graduate_dtb');
    Route::post('/graduatefilterReport', 'GraduateController@graduatefilterReport')->name('graduatefilterReport');
});
Route::group(['middleware' => ['auth', 'permission:create-graduate']], function() {
    Route::post('/addGraduate', 'GraduateController@addGraduate')->name('addGraduate');
    Route::post('/graduate_select', 'GraduateController@graduate_select')->name('graduate_select');
});

Route::group(['middleware' => ['auth', 'permission:edit-graduate']], function() {
    Route::post('/updateGraduate', 'GraduateController@updateGraduate')->name('updateGraduate');
    Route::get('/graduateEdit/{id}', 'GraduateController@graduateEdit')->name('graduateEdit');
});

Route::group(['middleware' => ['auth', 'permission:delete-graduate']], function() {
    Route::post('/deleteGraduate', 'GraduateController@deleteEnrollment')->name('deleteGraduate');
});

/**PERMISSIONS FOR NUMBER OF SCHOLARSHIP AND GRANTS */
Route::group(['middleware' => ['auth', 'permission:view-scholar']], function() {
    Route::get('/scholarIndex', 'ScholarshipController@index')->name('scholarIndex');
    Route::get('/scholar_dtb', 'ScholarshipController@scholar_dtb')->name('scholar_dtb');
    Route::post('/scholarfilterReport', 'ScholarshipController@scholarfilterReport')->name('scholarfilterReport');
    Route::get('/scholarDetail/{id}', 'ScholarshipController@scholarDetail')->name('scholarDetail');
    Route::get('/listScholar', 'ScholarshipController@listScholar')->name('listScholar');
});
Route::group(['middleware' => ['auth', 'permission:create-scholar']], function() {
    Route::post('/addScholar', 'ScholarshipController@addScholar')->name('addScholar');
    Route::post('/addList', 'ScholarshipController@addList')->name('addList');
    Route::get('/list_dtb', 'ScholarshipController@list_dtb')->name('list_dtb');
});

Route::group(['middleware' => ['auth', 'permission:edit-scholar']], function() {
    Route::post('/updateScholar', 'ScholarshipController@updateScholar')->name('updateScholar');
    Route::get('/scholarEdit/{id}', 'ScholarshipController@scholarEdit')->name('scholarEdit');
    Route::post('/updateList', 'ScholarshipController@updateList')->name('updateList');
    Route::post('/editList', 'ScholarshipController@editList')->name('editList');
});

Route::group(['middleware' => ['auth', 'permission:delete-scholar']], function() {
    Route::post('/deleteScholar', 'ScholarshipController@deleteScholar')->name('deleteScholar');
    Route::post('/deleteList', 'ScholarshipController@deleteList')->name('deleteList');
});