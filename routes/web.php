<?php

Route::get('/', 'MainController@index');

Route::get('/categories', 'CategoryController@index');
Route::post('/categories', 'CategoryController@store');
Route::put('/categories/{category}', 'CategoryController@update');
Route::delete('/categories/{category}', 'CategoryController@destroy');
Route::get('/categories/get-select-input', 'CategoryController@getSelectInput');

Route::get('/tasks', 'TaskController@index');
Route::post('/tasks', 'TaskController@store');
Route::put('/tasks/{task}', 'TaskController@update');
Route::put('/tasks/{task}/set-status', 'TaskController@setStatus');
Route::delete('/tasks/{task}', 'TaskController@destroy');
