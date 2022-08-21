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

    Route::get('roomitem', 'RoomitemsController@index')->name('roomitem');
    Route::group(['prefix' => 'roomitem', 'as'=>'roomitem.'], function () {
    Route::post('datatable-data', 'RoomitemsController@get_datatable_data')->name('datatable.data');
    Route::post('store-or-update', 'RoomitemsController@store_or_update_data')->name('store.or.update');
    Route::post('edit', 'RoomitemsController@edit')->name('edit');
    Route::post('delete', 'RoomitemsController@delete')->name('delete');
    Route::post('bulk-delete', 'RoomitemsController@bulk_delete')->name('bulk.delete');
    Route::post('change-status', 'RoomitemsController@change_status')->name('change.status');
    });

    Route::get('roommanage', 'RoomServiceManagesController@index')->name('roommanage');
    Route::group(['prefix' => 'roommanage', 'as'=>'roommanage.'], function () {
    Route::post('datatable-data', 'RoomServiceManagesController@get_datatable_data')->name('datatable.data');
    Route::post('store-or-update', 'RoomServiceManagesController@store_or_update_data')->name('store.or.update');
    Route::post('edit', 'RoomServiceManagesController@edit')->name('edit');
    Route::post('delete', 'RoomServiceManagesController@delete')->name('delete');
    Route::post('bulk-delete', 'RoomServiceManagesController@bulk_delete')->name('bulk.delete');
    Route::post('change-status', 'RoomServiceManagesController@change_status')->name('change.status');
    });
    
    Route::get('roomsetting','RoomsettingsController@index')->name('roomsetting');
    Route::post('general_roomsetting','RoomsettingsController@general_roomsettings')->name('general.roomsetting');
    
    
});