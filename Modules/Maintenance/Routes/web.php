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
    Route::get('team', 'TeamsController@index')->name('team');
    Route::group(['prefix' => 'team', 'as'=>'team.'], function () {
        Route::post('datatable-data', 'TeamsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'TeamsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'TeamsController@edit')->name('edit');
        Route::post('delete', 'TeamsController@delete')->name('delete');
        Route::post('bulk-delete', 'TeamsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'TeamsController@change_status')->name('change.status');
    });

    Route::get('tasktype', 'TasktypesController@index')->name('tasktype');
    Route::group(['prefix' => 'tasktype', 'as'=>'tasktype.'], function () {
        Route::post('datatable-data', 'TasktypesController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'TasktypesController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'TasktypesController@edit')->name('edit');
        Route::post('delete', 'TasktypesController@delete')->name('delete');
        Route::post('bulk-delete', 'TasktypesController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'TasktypesController@change_status')->name('change.status');
    });

    Route::get('task', 'TasksController@index')->name('task');
    Route::group(['prefix' => 'task', 'as'=>'task.'], function () {
        Route::post('datatable-data', 'TasksController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'TasksController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'TasksController@edit')->name('edit');
        Route::post('delete', 'TasksController@delete')->name('delete');
        Route::post('bulk-delete', 'TasksController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'TasksController@change_status')->name('change.status');
    });
});
