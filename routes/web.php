<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

// php artisan migrate                                  // ? fa la migrazione
// php artisan make:migration create_users_table        // ? crea nuova tabella
// php artisan migrate:refresh                          // ? aggiorna


// docker-compose up -d nginx mysql redis               // ? fa partire la macchina

// php artisan make:controller ShowProfile              // ? crea controller
// php artisan make:model Flight                        // ? Crea model eloquent