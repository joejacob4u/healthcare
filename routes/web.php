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

Route::get('/', 'HomeController@index');

/***************************Admin Route groups*******************************/

Route::group(['middleware' => ['auth','admin'],'prefix' => 'admin'], function ()
{
    Route::get('clients', 'AdminClientController@index');
    Route::get('clients/add', 'AdminClientController@addView');
    Route::post('clients/add', 'AdminClientController@create');

    Route::get('accreditation', 'AdminAccreditationController@index');
    Route::get('accreditation/add', 'AdminAccreditationController@addView');
    Route::post('accreditation/add', 'AdminAccreditationController@add');

    Route::get('accreditation/eop/{accreditation_id}', 'AdminAccreditationEOPController@index');
    Route::get('accreditation/eop/add/{accreditation_id}', 'AdminAccreditationEOPController@viewAddIndex');
    Route::post('accreditation/eop/add/{accreditation_id}', 'AdminAccreditationEOPController@create');



});

/***************************Client Route groups*******************************/

Route::group(['middleware' => ['auth']], function ()
{



});
