<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('home');
})->name('home');

Route::get('accrediation','AccrediationController@index');
Route::get('accrediation/add','AccrediationController@create');
Route::post('accrediation/add','AccrediationController@store');

Route::get('accrediation-requirements','AccrediationRequirementsController@index');
Route::get('accrediation-requirements/add','AccrediationRequirementsController@create');
Route::post('accrediation-requirements/add','AccrediationRequirementsController@store');
Route::get('accrediation-requirements/edit/{id}','AccrediationRequirementsController@edit');
Route::post('accrediation-requirements/edit/{id}','AccrediationRequirementsController@save');

Route::get('standard-label','StandardLabelController@index');
Route::get('standard-label/add','StandardLabelController@create');
Route::post('standard-label/add','StandardLabelController@store');
Route::get('standard-label/edit/{id}','StandardLabelController@edit');
Route::post('standard-label/edit/{id}','StandardLabelController@save');

Route::get('standard-label/{standard_label}/eop','EOPController@edit');
