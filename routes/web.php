<?php

Route::get('/', 'TransferFilesController@index');
// Auth callbacks
Route::get('/gmail-auth-callback', 'GoogleClientController@gmailAuthCallback')->name('gmail-auth-callback');
Route::get('/drive-auth-callback', 'GoogleClientController@driveAuthCallback')->name('drive-auth-callback');
// Logout
Route::get('/gmail-logout', 'GoogleClientController@gmailLogout')->name('gmail-logout');
Route::get('/drive-logout', 'GoogleClientController@driveLogout')->name('drive-logout');

Route::get('/transfer', 'TransferFilesController@transfer')->name('transfer');

