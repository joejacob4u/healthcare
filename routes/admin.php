<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('home');
})->name('home');

Route::get('accreditation','AccreditationController@index');
Route::get('accreditation/add','AccreditationController@create');
Route::post('accreditation/add','AccreditationController@store');
Route::get('accreditation/edit/{id}','AccreditationController@edit');
Route::post('accreditation/edit/{id}','AccreditationController@save');
Route::get('accreditation/delete/{id}','AccreditationController@delete');
Route::post('accreditation/info','AccreditationController@info');




Route::get('accreditation-requirements','AccreditationRequirementsController@index');
Route::get('accreditation-requirements/add','AccreditationRequirementsController@create');
Route::post('accreditation-requirements/add','AccreditationRequirementsController@store');
Route::get('accreditation-requirements/edit/{id}','AccreditationRequirementsController@edit');
Route::post('accreditation-requirements/edit/{id}','AccreditationRequirementsController@save');
Route::get('accreditation-requirements/delete/{id}','AccreditationRequirementsController@delete');
Route::post('accreditation-requirements/info','AccreditationRequirementsController@info');


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
