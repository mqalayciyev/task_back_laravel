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

Route::namespace('API')->group(function () {
    Route::apiResources([
        'login' => LoginController::class,
        'register' => RegisterController::class,
    ]);




    Route::group(['middleware' => 'auth:api'], function () {


        Route::get('/load-board', 'BoardController@load');
        Route::post('/add-update-task', 'TaskController@add_update_task');
        Route::post('/add-update-board', 'BoardController@add_update_board');

        Route::get('/control', 'LoginController@control');
        Route::post('/logout', 'LoginController@logout');

    });
});
