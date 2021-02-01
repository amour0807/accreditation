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
Route::group(['middleware' => ['auth', 'permission:view-user']], function() {
    Route::get('/userlist', 'UserController@index')->name('userlist');
    Route::get('/user/account_dtb/{id}', 'UserController@account_dtb')->name('account_dtb');
    Route::get('/user/userDetail/{id}', 'UserController@userDetail')->name('userDetail');
});

Route::get('/firstlogin', 'UserController@firstlogin')->name('firstlogin')->middleware('auth');
Route::post('/changePassword','UserController@changePassword')->name('changePassword')->middleware('auth');
// Route::group(['prefix' => 'accreditation', 'middleware' => 'is_admin'], function() {
    
Route::group(['middleware' => ['auth', 'permission:delete-user']], function() {
    Route::post('/deleteUser', 'UserController@deleteUser')->name('deleteUser');
});

Route::group(['middleware' => ['auth', 'permission:edit-user']], function() {
    Route::post('/editUser', 'UserController@editUser')->name('editUser');
    Route::post('/updateUser', 'UserController@updateUser')->name('updateUser');
    Route::get('/userEdit/{id}', 'UserController@userEdit')->name('userEdit');
});

Route::group(['middleware' => ['auth', 'permission:create-user']], function() {
    Route::get('/addUser', 'UserController@addUser')->name('addUser');
    Route::post('/createUser', 'UserController@createUser')->name('createUser');
});
