<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@authenticate');


        Route::post('storeevent', 'DataController@storeEvent');
        Route::get('user', 'UserController@getAuthenticatedUser');
        Route::get('closed', 'DataController@closed');
        Route::get('getevents', 'DataController@getPosts');
        Route::get('getcategories', 'DataController@getCategories');
    Route::get('likeset/{id}' , 'DataController@likeset');
    Route::get('check' , 'UserController@getAuthenticatedUser');
    Route::get('interestset/{id}' , 'DataController@interestSet');
    Route::get('postdetail/{id}' , 'DataController@postDetail');
    Route::post('savecomment' , 'DataController@commentSave');
    // Route::group(['middleware' => ['jwt.verify']], function() {
        
        
    // });
