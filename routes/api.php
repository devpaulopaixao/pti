<?php

use Illuminate\Http\Request;

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['namespace' => 'Site', 'as' => 'site.'], function(){
    
});


Route::resource('authenticate', 'Api\AuthenticateController', ['only' => ['index']]);
Route::post('authenticate', 'Api\AuthenticateController@authenticate');
