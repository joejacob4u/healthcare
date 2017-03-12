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
    Route::get('clients', 'Admin\AdminClientController@index');
    Route::get('clients/add', 'Admin\AdminClientController@addView');
    Route::post('clients/add', 'Admin\AdminClientController@create');

    Route::get('accreditation', 'Admin\AdminAccreditationController@index');
    Route::get('accreditation/add', 'Admin\AdminAccreditationController@addView');
    Route::post('accreditation/add', 'Admin\AdminAccreditationController@add');

    Route::get('accreditation/eop/{accreditation_id}', 'Admin\AdminAccreditationEOPController@index');
    Route::get('accreditation/eop/add/{accreditation_id}', 'Admin\AdminAccreditationEOPController@viewAddIndex');
    Route::post('accreditation/eop/add/{accreditation_id}', 'Admin\AdminAccreditationEOPController@create');

    Route::get('cop', 'Admin\AdminCOPController@index');
    Route::get('cop/add', 'Admin\AdminCOPController@addView');
    Route::post('cop/add', 'Admin\AdminCOPController@create');
    Route::get('cop/edit/{id}', 'Admin\AdminCOPController@editView');
    Route::post('cop/edit/{id}', 'Admin\AdminCOPController@save');
    Route::post('cop/delete', 'Admin\AdminCOPController@delete');
    Route::get('cop/{id}/subcop', 'Admin\SubCOPController@index');
    Route::get('cop/{id}/subcop/add', 'Admin\SubCOPController@addView');
    Route::post('cop/{id}/subcop/add', 'Admin\SubCOPController@create');











});

/***************************Client Route groups*******************************/

Route::group(['middleware' => ['auth']], function ()
{



});
