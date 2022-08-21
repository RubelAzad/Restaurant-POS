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
    Route::get('member', 'MembersController@index')->name('member');
    Route::group(['prefix' => 'member', 'as'=>'member.'], function () {
        Route::post('datatable-data', 'MembersController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'MembersController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'MembersController@edit')->name('edit');
        Route::post('delete', 'MembersController@delete')->name('delete');
        Route::post('bulk-delete', 'MembersController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'MembersController@change_status')->name('change.status');
    });

    Route::get('card', 'CardsController@index')->name('card');
    Route::group(['prefix' => 'card', 'as'=>'card.'], function () {
        Route::post('datatable-data', 'CardsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'CardsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'CardsController@edit')->name('edit');
        Route::post('delete', 'CardsController@delete')->name('delete');
        Route::post('bulk-delete', 'CardsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'CardsController@change_status')->name('change.status');
    });

    Route::get('membercard', 'MembercardsController@index')->name('membercard');
    Route::group(['prefix' => 'membercard', 'as'=>'membercard.'], function () {
        Route::post('datatable-data', 'MembercardsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'MembercardsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'MembercardsController@edit')->name('edit');
        Route::post('delete', 'MembercardsController@delete')->name('delete');
        Route::post('bulk-delete', 'MembercardsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'MembercardsController@change_status')->name('change.status');
    });
    
    Route::get('facilitysettings', 'FacilitysettingsController@index')->name('facilitysettings');
    Route::group(['prefix' => 'facilitysettings', 'as'=>'facilitysettings.'], function () {
    Route::post('datatable-data', 'FacilitysettingsController@get_datatable_data')->name('datatable.data');
    Route::post('store-or-update', 'FacilitysettingsController@store_or_update_data')->name('store.or.update');
    Route::post('edit', 'FacilitysettingsController@edit')->name('edit');
    Route::post('delete', 'FacilitysettingsController@delete')->name('delete');
    Route::post('bulk-delete', 'FacilitysettingsController@bulk_delete')->name('bulk.delete');
    Route::post('change-status', 'FacilitysettingsController@change_status')->name('change.status');
    });

    Route::get('facilitydiscount', 'FacilitydiscountsController@index')->name('facilitydiscount');
    Route::group(['prefix' => 'facilitydiscount', 'as'=>'facilitydiscount.'], function () {
    Route::post('datatable-data', 'FacilitydiscountsController@get_datatable_data')->name('datatable.data');
    Route::post('store-or-update', 'FacilitydiscountsController@store_or_update_data')->name('store.or.update');
    Route::post('edit', 'FacilitydiscountsController@edit')->name('edit');
    Route::post('delete', 'FacilitydiscountsController@delete')->name('delete');
    Route::post('bulk-delete', 'FacilitydiscountsController@bulk_delete')->name('bulk.delete');
    Route::post('change-status', 'FacilitydiscountsController@change_status')->name('change.status');
    Route::post('price','FacilitydiscountsController@facilityPrice')->name('price');
    });

    Route::get('cardtype', 'CardtypesController@index')->name('cardtype');
    Route::group(['prefix' => 'cardtype', 'as'=>'cardtype.'], function () {
        Route::post('datatable-data', 'CardtypesController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'CardtypesController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'CardtypesController@edit')->name('edit');
        Route::post('delete', 'CardtypesController@delete')->name('delete');
        Route::post('bulk-delete', 'CardtypesController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'CardtypesController@change_status')->name('change.status');
    });
});
