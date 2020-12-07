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

Route::group(['prefix' => 'boardexam', 'middleware' => 'is_admin'], function() {
    Route::get('/boardExam', 'BoardExamController@index')->name('boardExam');
    Route::post('/addBoardExam', 'BoardExamController@addBoardExam')->name('addBoardExam');
 	Route::get('/boardexam_dtb', 'BoardExamController@boardexam_dtb')->name('boardexam_dtb');
 	Route::get('/boardDetail/{id}', 'BoardExamController@boardDetail')->name('boardDetail');
 	Route::post('/boardfilterReport', 'BoardExamController@boardfilterReport')->name('boardfilterReport');
 	Route::get('/boardHistory/{id}', 'BoardExamController@boardHistory')->name('boardHistory');
 	Route::get('/boardHistory_dtb', 'BoardExamController@boardHistory_dtb')->name('boardHistory_dtb');
 	Route::post('/bHistoryfilterReport', 'BoardExamController@bHistoryfilterReport')->name('bHistoryfilterReport');

 	//topnotchers
 	Route::get('/topnotchers', 'BoardExamController@topnotchers')->name('topnotchers');
 	Route::get('/topnotcher_dtb', 'BoardExamController@topnotcher_dtb')->name('topnotcher_dtb');
 	Route::post('/topfilterReport', 'BoardExamController@topfilterReport')->name('topfilterReport');
});
