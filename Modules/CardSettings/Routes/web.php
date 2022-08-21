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


Route::group(['middleware' => ['auth']], function () {
    
    Route::get('cardsetting','CardSettingsController@index')->name('cardsetting');
    Route::post('general-cardsetting','CardSettingsController@general_cardsetting')->name('general.cardsetting');
    
    
});
