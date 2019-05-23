<?php

Route::get('tracers', 'Tracer\TracerController@index');
Route::post('tracers', 'Tracer\TracerController@store');
Route::get('tracer/create', 'Tracer\TracerController@create');
Route::get('tracer/evaluate/{tracer}', 'Tracer\TracerController@evaluate');
Route::post('tracer/fetch-checklist-types', 'Tracer\TracerController@fetchChecklistTypes');
Route::post('tracer/{tracer}/question/findings', 'Tracer\TracerController@saveFinding');
Route::post('tracer/question/findings/verify', 'Tracer\TracerController@verify');
