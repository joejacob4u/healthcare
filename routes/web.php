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
Route::get('/logout', 'HomeController@logout');

Route::get('/welcome', function(){
  return view('welcome');
});

Route::get('prospects/register','RegistrationController@index');
Route::post('prospects/register','RegistrationController@create');

Route::get('forgot/password','UsersController@forgotView');
Route::post('forgot/password','UsersController@sendTempPassword');


/***************************Admin Route groups*******************************/


/***************************Client Route groups*******************************/

Route::group(['middleware' => ['auth']], function ()
{
    Route::get('users', 'UsersController@index');
    Route::get('users/add', 'UsersController@create');
    Route::post('users/add', 'UsersController@store');
    Route::get('users/edit/{id}', 'UsersController@edit');
    Route::post('users/edit/{id}', 'UsersController@save');    
    Route::post('users/delete', 'UsersController@delete');
    Route::post('user/password/temporary/check', 'UsersController@temporaryCheck');
    Route::post('user/password/temporary/change', 'UsersController@temporaryChange');

    Route::get('users/prospects', 'SystemProspectsController@index');
    Route::get('users/prospects/details', 'SystemProspectsController@details');


    Route::get('prequalify', 'PrequalifyController@index');
    Route::post('prequalify/configure', 'PrequalifyController@store');
    Route::get('prequalify/configure', 'PrequalifyController@create');
    Route::post('prequalify/upload', 'PrequalifyController@upload');

    Route::get('contractor/prequalify', 'ContractorPrequalifyController@index');
    Route::get('contractor/prequalify/apply/{id}', 'ContractorPrequalifyController@create');
    Route::get('contractor/prequalify/download/{id}', 'ContractorPrequalifyController@download');
    Route::post('contractor/prequalify/upload', 'ContractorPrequalifyController@upload');
    Route::post('contractor/prequalify/apply', 'ContractorPrequalifyController@apply');

});




Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});
