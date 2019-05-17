<?php

Route::get('assessments', 'Assessment\AssessmentController@index');
Route::post('assessments', 'Assessment\AssessmentController@store');
Route::get('assessment/create', 'Assessment\AssessmentController@create');
Route::get('assessment/evaluate/{assessment}', 'Assessment\AssessmentController@evaluate');
Route::post('assessment/fetch-checklist-types', 'Assessment\AssessmentController@fetchChecklistTypes');
Route::post('assessment/{assessment}/question/findings', 'Assessment\AssessmentController@saveFinding');
Route::post('assessment/question/findings/verify', 'Assessment\AssessmentController@verify');
