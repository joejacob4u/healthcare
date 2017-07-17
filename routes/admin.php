<?php

Route::get('/home', function () {
    $users[] = Auth::guard('admin')->user();
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
Route::post('standard-label/filter','StandardLabelController@filter');
Route::post('standard-label/fetch/accreditation-requirements','StandardLabelController@fetchAccreditationRequirements');


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
Route::get('cop/{cop_id}/subcop/edit/{sub_cop_id}','SubCOPController@editView');
Route::post('cop/{cop_id}/subcop/edit/{sub_cop_id}','SubCOPController@save');
Route::post('subcop/delete','SubCOPController@delete');

Route::get('clients','AdminClientController@index');
Route::get('clients/add','AdminClientController@addView');
Route::post('clients/add','AdminClientController@create');
Route::get('clients/edit/{client_id}','AdminClientController@edit');
Route::post('clients/edit/{client_id}','AdminClientController@save');



Route::get('aorn','COPController@index');

Route::get('hco','WorkOrders\AssigneesController@index');



Route::get('work/assignees','WorkOrders\AssigneesController@index');
Route::get('work/assignees/add','WorkOrders\AssigneesController@create');
Route::post('work/assignees/add','WorkOrders\AssigneesController@store');
Route::get('work/assignees/edit/{id}','WorkOrders\AssigneesController@edit');
