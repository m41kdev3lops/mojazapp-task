<?php

// ---------------- POST ROUTES ----------------

// User POST routes
Route::post('/register', 'userController@register');
Route::post('/login', 'userController@login');
Route::post('/logout', 'userController@logout')->middleware('myAuth');

// list POST routes
Route::post('/list', 'listController@list_all')->middleware('myAuth');                                  // View all lists
Route::post('/list/create', 'listController@store')->middleware('myAuth', 'validateUserInput:list');    // Create a new list
