<?php

Route::group(['middleware' => ['auth', 'permission:view-partner']], function() {
 	Route::get('/partners', 'PartnerController@index')->name('partners');
 	Route::get('/partner_dtb', 'PartnerController@partner_dtb')->name('partner_dtb');
 	Route::get('/partner_history_dtb/{id}', 'PartnerController@partner_history_dtb')->name('partner_history_dtb');
 	Route::get('/partnerHistory/{id}', 'PartnerController@partnerHistory')->name('partnerHistory');
 	Route::get('/partnerDetail/{id}', 'PartnerController@partnerDetail')->name('partnerDetail');
	Route::post('/partnerfilterReport', 'PartnerController@partnerfilterReport')->name('partnerfilterReport'); 
 });
 
Route::group(['middleware' => ['auth', 'permission:edit-partner']], function() {
	Route::post('/updatePartner', 'PartnerController@updatePartner')->name('updatePartner');
});
Route::group(['middleware' => ['auth', 'permission:create-partner']], function() {
	Route::post('/addPartner', 'PartnerController@addPartner')->name('addPartner');
	Route::post('/renewPartner', 'PartnerController@renewPartner')->name('renewPartner');
});
Route::group(['middleware' => ['auth', 'permission:delete-partner']], function() {
	Route::post('/deletePartner', 'PartnerController@deletePartner')->name('deletePartner');
});