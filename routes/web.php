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

Auth::routes();

// home
Route::get('/', 'HomeController@index')->name('home');

// profile
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/profile/update', 'HomeController@updateProfile')->name('profile_update');

// assistenza
Route::get('/help', 'HomeController@help')->name('help');
Route::post('/help/send', 'HomeController@sendHelp')->name('help_send');

// gestione network (company/store/account)
Route::get('/network', 'NetworkController@index')->name('network');
Route::get('/network/company/create', 'CompanyController@create')->name('company_create');
Route::post('/network/company/insert', 'CompanyController@insert')->name('company_insert');
Route::post('/network/company/delete', 'CompanyController@delete')->name('company_delete');
Route::get('/network/company/{company_id}/edit', 'CompanyController@edit')->name('company_edit');
Route::post('/network/company/update', 'CompanyController@update')->name('company_update');

Route::get('/network/company/{company_id}/stores', 'StoreController@index')->name('stores_list');
Route::get('/network/company/{company_id}/store/create', 'StoreController@create')->name('store_create');
Route::post('/network/store/insert', 'StoreController@insert')->name('store_insert');
Route::post('/network/store/delete', 'StoreController@delete')->name('store_delete');
Route::get('/network/store/{store_id}/edit', 'StoreController@edit')->name('store_edit');
Route::post('/network/store/update', 'StoreController@update')->name('store_update');

Route::get('/account', 'AccountController@index')->name('account');
Route::get('/account/create', 'AccountController@create')->name('account_create');
Route::post('/account/insert', 'AccountController@insert')->name('account_insert');
Route::post('/account/delete', 'AccountController@delete')->name('account_delete');
Route::get('/account/{account_id}/edit', 'AccountController@edit')->name('account_edit');
Route::post('/account/update', 'AccountController@update')->name('account_update');

// gestione beacon
Route::get('/beacon', 'BeaconController@index')->name('beacon');
Route::get('/beacon/create', 'BeaconController@create')->name('beacon_create');
Route::post('/beacon/insert', 'BeaconController@insert')->name('beacon_insert');
Route::post('/beacon/delete', 'BeaconController@delete')->name('beacon_delete');
Route::get('/beacon/{beacon_id}/edit', 'BeaconController@edit')->name('beacon_edit');
Route::post('/beacon/update', 'BeaconController@update')->name('beacon_update');

//gestione gruppi
Route::get('/group', 'GroupController@index')->name('group');
Route::get('/group/create', 'GroupController@create')->name('group_create');
Route::post('/group/insert', 'GroupController@insert')->name('group_insert');
Route::post('/group/delete', 'GroupController@delete')->name('group_delete');
Route::get('/group/{group_id}/edit', 'GroupController@edit')->name('group_edit');
Route::post('/group/update', 'GroupController@update')->name('group_update');
Route::get('/group/{group_id}/settings', 'GroupController@settings')->name('group_settings');
Route::post('/group/settings/update', 'GroupController@updateSettings')->name('group_settings_update');

//gestione qrcodes
Route::get('/qrcode', 'QrCodeController@index')->name('qrcode');
Route::get('/qrcode/create', 'QrCodeController@create')->name('qrcode_create');
Route::post('/qrcode/insert', 'QrCodeController@insert')->name('qrcode_insert');
Route::post('/qrcode/delete', 'QrCodeController@delete')->name('qrcode_delete');
Route::get('/access/{code}', 'QrCodeController@access')->name('qrcode_access');

// ajax
Route::post('/city/get', 'CityController@getCities')->name('cities_get');
Route::post('/account/insert/fast', 'AccountController@fastInsert')->name('account_insert_fast');


// api
Route::post('/api/v1/users/login', 'ApiController@loginUser')->name('api_user_login');
Route::get('/api/v1/users/list', 'ApiController@getUsers')->name('api_user_list');
Route::get('/api/v1/users/{user_id}', 'ApiController@getUserById')->name('api_user_id');
