<?php

// ---------------- POST ROUTES ----------------

// User POST routes
Route::post('/register', 'userController@register');
Route::post('/login', 'userController@login');
Route::post('/logout', 'userController@logout')->middleware('myAuth');

// list POST routes
Route::post('/list', 'listController@list_all')->middleware('myAuth');                                                                      // View all lists.
Route::post('/list/create', 'listController@store')->middleware('myAuth', 'validateUserInput:list');                                       // Create a new list.
Route::post('/list/{list}', 'listController@view')->middleware('myAuth', 'checkIfListBelongsToUser');                                     //  View a specific list with its items. 
Route::post('/list/{list}/delete', 'listController@destroy')->middleware('myAuth', 'checkIfListBelongsToUser');                          // Delete a list.
Route::post('/list/{list}/edit', 'listController@edit')->middleware('myAuth', 'checkIfListBelongsToUser', 'validateUserInput:list');    // Edit a list.

// item POST routes
Route::post('/list/{list}/item', 'itemController@store')->middleware('myAuth', 'checkIfListBelongsToUser', 'validateUserInput:item');               // Create a new item.
Route::post('/list/{list}/item/{item}/edit', 'itemController@edit')->middleware('myAuth', 'checkIfListBelongsToUser', 'validateUserInput:item');   // Edit a specific item.
Route::post('/list/{list}/item/{item}/delete', 'itemController@destroy')->middleware('myAuth', 'checkIfListBelongsToUser');                       // Delete a specific item.
Route::post('/list/{list}/item/{item}', 'itemController@view')->middleware('myAuth', 'checkIfListBelongsToUser');                                // View a specific item.
