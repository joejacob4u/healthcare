<?php

//sections

Route::get('admin/tracer/sections', 'Tracer\SectionController@index');
Route::post('admin/tracer/sections', 'Tracer\SectionController@store');
Route::post('admin/tracer/sections/delete', 'Tracer\SectionController@destroy');


Route::get('admin/tracer/{section}/checklist-types', 'Tracer\ChecklistTypeController@index');
Route::post('admin/tracer/{section}/checklist-types', 'Tracer\ChecklistTypeController@store');
Route::post('admin/tracer/{section}/checklist-types/edit', 'Tracer\ChecklistTypeController@save');
Route::post('admin/tracer/checklist-type/delete', 'Tracer\ChecklistTypeController@destroy');

Route::get('admin/tracer/checklist-type/{checklist_type}/categories', 'Tracer\CategoryController@index');
Route::post('admin/tracer/checklist-type/{checklist_type}/categories', 'Tracer\CategoryController@store');
Route::post('admin/tracer/categories/delete', 'Tracer\CategoryController@destroy');

Route::get('admin/tracer/categories/{category}/questions', 'Tracer\QuestionController@index');
Route::post('admin/tracer/categories/{category}/questions', 'Tracer\QuestionController@store');
Route::get('admin/tracer/categories/{category}/questions/create', 'Tracer\QuestionController@create');
Route::get('admin/tracer/categories/{category}/questions/{question}/edit', 'Tracer\QuestionController@edit');
Route::post('admin/tracer/categories/{category}/questions/{question}/edit', 'Tracer\QuestionController@update');
Route::post('admin/tracer/categories/{category}/questions/delete', 'Tracer\QuestionController@destroy');
Route::post('admin/tracer/categories/{category}/questions/fetch-trades', 'Tracer\QuestionController@fetchTrades');
Route::post('admin/tracer/categories/{category}/questions/fetch-problems', 'Tracer\QuestionController@fetchProblems');
