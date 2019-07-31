<?php

//system admin front end

Route::get('system-admin/huddle/configs', 'Huddle\ConfigController@index');
Route::get('system-admin/huddle/configs/create', 'Huddle\ConfigController@create');
Route::post('system-admin/huddle/configs', 'Huddle\ConfigController@store');
Route::get('system-admin/huddle/configs/{huddle_config}/edit', 'Huddle\ConfigController@edit');
Route::post('system-admin/huddle/configs/{huddle_config}/edit', 'Huddle\ConfigController@save');
Route::post('system-admin/huddle/configs/delete', 'Huddle\ConfigController@delete');
Route::post('system-admin/huddle/configs/fetch/care-teams', 'Huddle\ConfigController@fetchReportToCareTeams');


Route::get('system-admin/huddle/care-team/create', 'Huddle\CareTeamController@create');
Route::post('system-admin/huddle/care-teams', 'Huddle\CareTeamController@store');
Route::get('system-admin/huddle/care-teams/{care_team}/edit', 'Huddle\CareTeamController@edit');
Route::post('system-admin/huddle/care-teams/{care_team}/edit', 'Huddle\CareTeamController@update');
Route::post('system-admin/huddle/care-teams/delete', 'Huddle\CareTeamController@delete');
Route::post('system-admin/huddle/care-teams/fetch-care-teams', 'Huddle\CareTeamController@fetchCareTeams');

//user front end

Route::get('huddle', 'Huddle\HuddleController@index');
Route::get('huddle/create', 'Huddle\HuddleController@create');
Route::post('huddle', 'Huddle\HuddleController@store');
Route::get('huddle/{huddle}', 'Huddle\HuddleController@view');
