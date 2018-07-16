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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('jwt.auth:api')->post('api-test', function(){
	return response()->json('la la la');
});


Route::post('/login', 'Api\\Auth@login');
Route::post('/register', 'Api\\Auth@register');
Route::post('/forgot-password', 'Api\\Auth@forgotPassword');
Route::post('/reset-password', 'Api\\Auth@resetPassword');
Route::post('/logout', 'Api\\Auth@logout');

Route::prefix('common')->group(function (){
    Route::get('/homeinfo', 'Api\\Common@homeinfo');
    Route::get('/categorylist', 'Api\\Common@categorylist');
});

Route::prefix('business')->group(function (){
    Route::get('/search', 'Api\\Business@search');
    Route::get('/detail', 'Api\\Business@detail');
    Route::get('/businesslisting', 'Api\\Business@businesslisting');
    Route::post('/editbusinesslisting', 'Api\\Business@editbusinesslisting');
    Route::get('/getpackage', 'Api\\Business@getpackage');
    Route::post('/setpackage', 'Api\\Business@setpackage');
    Route::post('/setcouponcode', 'Api\\Business@setcouponcode');
    Route::get('/getdashboardinfo', 'Api\\Business@getdashboardinfo');
    Route::get('/getreview', 'Api\\Business@getreview');
});

Route::prefix('category')->group(function (){

});

Route::prefix('message')->group(function (){
    Route::post('/makeconversation', 'Api\\Message@makeconversation');
    Route::get('/conversationlist', 'Api\\Message@conversationlist');
    Route::get('/getmessagelist', 'Api\\Message@getmessagelist');
    Route::post('/sendmessage', 'Api\\Message@sendmessage');
});

Route::prefix('project')->group(function (){
    Route::get('/projectlist', 'Api\\Project@projectlist');
    Route::get('/getcustomerforproject', 'Api\\Project@getcustomerforproject');
    Route::post('/editproject', 'Api\\Project@editproject');
    Route::post('/activeproject', 'Api\\Project@activeproject');
    Route::post('/completeproject', 'Api\\Project@completeproject');
    Route::post('/approveproject', 'Api\\Project@approveproject');
    Route::post('/delproject', 'Api\\Project@delproject');
});

Route::prefix('user')->group(function (){
    Route::get('/getprofile', 'Api\\User@getprofile');
    Route::post('/setprofile', 'Api\\User@setprofile');
    Route::post('/changepassword', 'Api\\User@changepassword');
});