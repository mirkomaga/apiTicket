<?php

use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Contracts\Auth\Authenticatable;
=======
use Illuminate\Support\Facades\Route;
>>>>>>> 166abfa35c535f4572d5971a99aec45cc8c63ff6

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

Route::group(['middleware' => 'auth:api'], function() {
    Route::put('ticket/{id}', 'TicketController@update');
    Route::get('ticket', 'TicketController@getAll');
    Route::get('ticket/{id}', 'TicketController@getSingolo');
    Route::post('ticket', 'TicketController@add');
    Route::delete('ticket/{id}', 'TicketController@delete');

    Route::get('/ticketFiltered', 'TicketController@getFiltred');
});

Route::group(['prefix' => 'password'], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});


Route::group(['middleware' => ['auth:api', 'admin']], function () {
    Route::put('assegnaTicket/{id}', 'AssegnaTicketController@update');
    Route::get('assegnaTicket', 'AssegnaTicketController@getAll');
    Route::get('assegnaTicket/{id}', 'AssegnaTicketController@getSingolo');
    Route::post('assegnaTicket', 'AssegnaTicketController@add');
    Route::delete('assegnaTicket/{id}', 'AssegnaTicketController@delete');

    Route::get('getUser', 'UserController@getUser');
    Route::get('allFiltered', 'TicketController@getFiltredAdmin');
});
