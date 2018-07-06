<?php

use Spatie\Fractal\Fractal;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;

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
    Route::post('auth/register', 'Api\RegisterController@register')->name('Register');
    Route::post('auth/login', 'Api\LoginController@login')->name('Login');
    Route::get('users', 'Api\UsersController@index')->name('List Users');

    Route::group(['prefix' => 'v1', 'middleware' => 'jwt.auth'], function () {
        Route::get('/', function (Request $request) {
            return json_encode(['version' => '1.0.0', 'title' => 'Blog API']);
        })->name('Root');

        Route::get('me', function (Request $request) {
            return Fractal::create(auth()->user(), new UserTransformer())->respond(200, [], JSON_PRETTY_PRINT);
        })->name('My Profile');

        Route::get('users', 'Api\UsersController@index')->name('List Users');
        Route::get('user/{id}', 'Api\UsersController@get')->where('id', '[0-9]+')->name('User Profile');
    });
