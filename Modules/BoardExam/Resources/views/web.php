<?php

/**PERMISSIONS FOR INSTITUTIONAL AWARDS */
Route::group(['middleware' => ['auth', 'permission:view-board']], function() {
    Route::get('/boardExam', 'BoardExamController@index')->name('boardExam');
 	Route::get('/boardexam_dtb', 'BoardExamController@boardexam_dtb')->name('boardexam_dtb');
     Route::get('/boardDetail/{id}', 'BoardExamController@boardDetail')->name('boardDetail');
 	Route::post('/boardfilterReport', 'BoardExamController@boardfilterReport')->name('boardfilterReport');
 	Route::get('/boardHistory/{licensure_exam}', 'BoardExamController@boardHistory')->name('boardHistory');
 	Route::get('/boardHistory_dtb/{exam}', 'BoardExamController@boardHistory_dtb')->name('boardHistory_dtb');
 	Route::post('/bHistoryfilterReport', 'BoardExamController@bHistoryfilterReport')->name('bHistoryfilterReport');
     
 	//topnotchers
 	Route::get('/topnotchers', 'BoardExamController@topnotchers')->name('topnotchers');
 	Route::get('/topnotcher_dtb', 'BoardExamController@topnotcher_dtb')->name('topnotcher_dtb');
 	Route::post('/topfilterReport', 'BoardExamController@topfilterReport')->name('topfilterReport');
});

Route::group(['middleware' => ['auth', 'permission:edit-board']], function() {
	 Route::get('/boardEdit/{id}', 'BoardExamController@boardEdit')->name('boardEdit');
	 Route::post('/updateBoard', 'BoardExamController@updateBoard')->name('updateBoard');
});

Route::group(['middleware' => ['auth', 'permission:create-board']], function() {
    Route::post('/addBoardExam', 'BoardExamController@addBoardExam')->name('addBoardExam');
});

Route::group(['middleware' => ['auth', 'permission:delete-board']], function() {
	Route::post('/deleteBoard', 'BoardExamController@deleteBoard')->name('deleteBoard');
});