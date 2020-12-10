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

Route::group(['prefix' => 'partner', 'middleware' => 'is_admin'], function() {
    Route::get('/', 'PartnerController@index');
 	Route::get('/partners', 'PartnerController@index')->name('partners');
 	Route::get('/partner_dtb', 'PartnerController@partner_dtb')->name('partner_dtb');
 	Route::get('/partner_history_dtb/{id}', 'PartnerController@partner_history_dtb')->name('partner_history_dtb');
 	Route::post('/addPartner', 'PartnerController@addPartner')->name('addPartner');
 	Route::post('/renewPartner', 'PartnerController@renewPartner')->name('renewPartner');
 	Route::post('/deletePartner', 'PartnerController@deletePartner')->name('deletePartner');
 	Route::get('/partnerEdit/{id}', 'PartnerController@partnerEdit')->name('partnerEdit');
 	Route::get('/partnerDetail/{id}', 'PartnerController@partnerDetail')->name('partnerDetail');
	Route::post('/updatePartner', 'PartnerController@updatePartner')->name('updatePartner');
	Route::post('/partnerfilterReport', 'PartnerController@partnerfilterReport')->name('partnerfilterReport'); 
 });