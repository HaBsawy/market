<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'AuthController@register')->name('register');
Route::post('login', 'AuthController@login')->name('login');
Route::post('logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => ['web']], function () {
    Route::get('/redirect', 'SocialAuthFacebookController@redirect');
    Route::get('/callback', 'SocialAuthFacebookController@callback');

    Route::get('login/google', 'SocialAuthFacebookController@googleRedirect');
    Route::get('login/google/callback', 'SocialAuthFacebookController@googleCallback');
});



Route::get('simple', function () {
    return '<a href=" ' . url('api/redirect') . ' " class="btn btn-primary">Login with Facebook</a>';
});
