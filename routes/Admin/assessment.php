<?php


Route::get('admin/assessment/checklist-types', 'Assessment\ChecklistTypeController@index');
Route::post('admin/assessment/checklist-types', 'Assessment\ChecklistTypeController@store');
Route::post('admin/assessment/checklist-types/edit', 'Assessment\ChecklistTypeController@save');
Route::post('admin/assessment/checklist-type/delete', 'Assessment\ChecklistTypeController@destroy');

Route::get('admin/assessment/checklist-type/{checklist_type}/categories', 'Assessment\CategoryController@index');
Route::post('admin/assessment/checklist-type/{checklist_type}/categories', 'Assessment\CategoryController@store');
Route::post('admin/assessment/categories/delete', 'Assessment\CategoryController@destroy');

Route::get('admin/assessment/categories/{category}/questions', 'Assessment\QuestionController@index');
Route::post('admin/assessment/categories/{category}/questions', 'Assessment\QuestionController@store');
Route::get('admin/assessment/categories/{category}/questions/create', 'Assessment\QuestionController@create');
Route::get('admin/assessment/categories/{category}/questions/{question}/edit', 'Assessment\QuestionController@edit');
Route::post('admin/assessment/categories/{category}/questions/{question}/edit', 'Assessment\QuestionController@update');
Route::post('admin/assessment/categories/{category}/questions/delete', 'Assessment\QuestionController@destroy');
Route::post('admin/assessment/categories/{category}/questions/fetch-trades', 'Assessment\QuestionController@fetchTrades');
Route::post('admin/assessment/categories/{category}/questions/fetch-problems', 'Assessment\QuestionController@fetchProblems');
