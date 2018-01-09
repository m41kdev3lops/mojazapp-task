<?php

// ---------------- POST ROUTES ----------------

// User POST routes
Route::post('/register', 'userController@register');
Route::post('/login', 'userController@login');
Route::post('/logout', 'userController@logout')->middleware('myAuth');
