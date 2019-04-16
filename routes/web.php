<?php
Route::get('password/reset',
    'Auth\ForgotPasswordController@showLinkRequestForm')
    ->name('password.request');

Route::post('password/email',
    'Auth\ForgotPasswordController@sendResetLinkEmail')
    ->name('password.email');

Route::get('password/reset/{token}',
    'Auth\ResetPasswordController@showResetForm')
    ->name('password.reset');

Route::post('password/reset',
    'Auth\ResetPasswordController@reset')
    ->name('password.reset.submit');

    Route::get('logout' , function(){
    	auth()->logout();
    });