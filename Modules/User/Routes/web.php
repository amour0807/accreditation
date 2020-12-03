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

Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index');
    Route::post('/addUser', 'UserController@addUser')->name('addUser');
    Route::get('/user/account_dtb/{id}', 'UserController@account_dtb')->name('account_dtb');
    
});
Route::group(['prefix' => 'accreditation', 'middleware' => 'is_admin'], function() {
    Route::post('/deleteUser', 'UserController@deleteUser')->name('deleteUser');

     Route::post('/editUser', 'UserController@editUser')->name('editUser');
     
Route::post('/updateUser', 'UserController@updateUser')->name('updateUser');
});
