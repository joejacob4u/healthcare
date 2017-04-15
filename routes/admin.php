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
Route::get('accrediation/edit/{id}','AccrediationController@edit');
Route::post('accrediation/edit/{id}','AccrediationController@save');
Route::get('accrediation/delete/{id}','AccrediationController@delete');




Route::get('accrediation-requirements','AccrediationRequirementsController@index');
Route::get('accrediation-requirements/add','AccrediationRequirementsController@create');
Route::post('accrediation-requirements/add','AccrediationRequirementsController@store');
Route::get('accrediation-requirements/edit/{id}','AccrediationRequirementsController@edit');
Route::post('accrediation-requirements/edit/{id}','AccrediationRequirementsController@save');
Route::get('accrediation-requirements/delete/{id}','AccrediationRequirementsController@delete');


Route::get('standard-label','StandardLabelController@index');
Route::get('standard-label/add','StandardLabelController@create');
Route::post('standard-label/add','StandardLabelController@store');
Route::get('standard-label/edit/{id}','StandardLabelController@edit');
Route::post('standard-label/edit/{id}','StandardLabelController@save');
Route::get('standard-label/delete/{id}','StandardLabelController@delete');


Route::get('standard-label/{standard_label}/eop','EOPController@index');
Route::get('standard-label/{standard_label}/eop/add','EOPController@create');
Route::post('standard-label/{standard_label}/eop/add','EOPController@store');
Route::get('standard-label/{standard_label}/eop/edit/{eop}','EOPController@edit');
Route::post('standard-label/{standard_label}/eop/edit/{eop}','EOPController@save');
Route::get('standard-label/{standard_label}/eop/delete/{eop}','EOPController@delete');

Route::get('cop','COPController@index');
Route::get('cop/add','COPController@addView');
Route::post('cop/add','COPController@create');
Route::get('cop/edit/{id}','COPController@editView');
Route::post('cop/edit/{id}','COPController@save');
Route::post('cop/delete','COPController@delete');

Route::get('cop/{id}/subcop','SubCOPController@index');
Route::get('cop/{id}/subcop/add','SubCOPController@addView');
Route::post('cop/{id}/subcop/add','SubCOPController@create');
