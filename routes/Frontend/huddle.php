<?php

Route::get('system-admin/huddle/configs', 'Huddle\ConfigController@index');
Route::get('system-admin/huddle/configs/create', 'Huddle\ConfigController@create');
Route::post('system-admin/huddle/configs', 'Huddle\ConfigController@store');
Route::get('system-admin/huddle/configs/{huddle_config}/edit', 'Huddle\ConfigController@edit');
Route::post('system-admin/huddle/configs/{huddle_config}/edit', 'Huddle\ConfigController@save');
Route::post('system-admin/huddle/configs/delete', 'Huddle\ConfigController@delete');
