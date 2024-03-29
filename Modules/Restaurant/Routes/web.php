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
    Route::get('rcategory', 'RcategoryController@index')->name('rcategory');
    Route::group(['prefix' => 'rcategory', 'as'=>'rcategory.'], function () {
        Route::post('datatable-data', 'RcategoryController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RcategoryController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RcategoryController@edit')->name('edit');
        Route::post('delete', 'RcategoryController@delete')->name('delete');
        Route::post('bulk-delete', 'RcategoryController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RcategoryController@change_status')->name('change.status');
        Route::get('/get-category', 'RcategoryController@apiGetCategrory');
    });

    Route::get('rfloor', 'RfloorsController@index')->name('rfloor');
    Route::group(['prefix' => 'rfloor', 'as'=>'rfloor.'], function () {
        Route::post('datatable-data', 'RfloorsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RfloorsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RfloorsController@edit')->name('edit');
        Route::post('delete', 'RfloorsController@delete')->name('delete');
        Route::post('bulk-delete', 'RfloorsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RfloorsController@change_status')->name('change.status');
    });

    Route::get('rtable', 'RtablesController@index')->name('rtable');
    Route::group(['prefix' => 'rtable', 'as'=>'rtable.'], function () {
        Route::post('datatable-data', 'RtablesController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RtablesController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RtablesController@edit')->name('edit');
        Route::post('delete', 'RtablesController@delete')->name('delete');
        Route::post('bulk-delete', 'RtablesController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RtablesController@change_status')->name('change.status');
    });

    Route::get('ritem', 'RitemsController@index')->name('ritem');
    Route::group(['prefix' => 'ritem', 'as'=>'ritem.'], function () {
        Route::post('datatable-data', 'RitemsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RitemsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RitemsController@edit')->name('edit');
        Route::post('delete', 'RitemsController@delete')->name('delete');
        Route::post('bulk-delete', 'RitemsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RitemsController@change_status')->name('change.status');
    });
    Route::get('rvariant', 'RvariantsController@index')->name('rvariant');
    Route::group(['prefix' => 'rvariant', 'as'=>'rvariant.'], function () {
        Route::post('datatable-data', 'RvariantsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RvariantsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RvariantsController@edit')->name('edit');
        Route::post('delete', 'RvariantsController@delete')->name('delete');
        Route::post('bulk-delete', 'RvariantsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RvariantsController@change_status')->name('change.status');
    });
    Route::get('raddon', 'RaddonsController@index')->name('raddon');
    Route::group(['prefix' => 'raddon', 'as'=>'raddon.'], function () {
        Route::post('datatable-data', 'RaddonsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RaddonsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RaddonsController@edit')->name('edit');
        Route::post('delete', 'RaddonsController@delete')->name('delete');
        Route::post('bulk-delete', 'RaddonsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RaddonsController@change_status')->name('change.status');
    });
    Route::get('raddonassign', 'RaddonassignsController@index')->name('raddonassign');
    Route::group(['prefix' => 'raddonassign', 'as'=>'raddonassign.'], function () {
        Route::post('datatable-data', 'RaddonassignsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RaddonassignsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RaddonassignsController@edit')->name('edit');
        Route::post('delete', 'RaddonassignsController@delete')->name('delete');
        Route::post('bulk-delete', 'RaddonassignsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RaddonassignsController@change_status')->name('change.status');
    });
    Route::get('rdiscount', 'RdiscountsController@index')->name('rdiscount');
    Route::group(['prefix' => 'rdiscount', 'as'=>'rdiscount.'], function () {
        Route::post('datatable-data', 'RdiscountsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RdiscountsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RdiscountsController@edit')->name('edit');
        Route::post('delete', 'RdiscountsController@delete')->name('delete');
        Route::post('bulk-delete', 'RdiscountsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RdiscountsController@change_status')->name('change.status');
    });

    Route::get('rsetting', 'RsettingsController@index')->name('rsetting');
    Route::group(['prefix' => 'rsetting', 'as'=>'rsetting.'], function () {
        Route::post('datatable-data', 'RsettingsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'RsettingsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'RsettingsController@edit')->name('edit');
        Route::post('delete', 'RsettingsController@delete')->name('delete');
        Route::post('bulk-delete', 'RsettingsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'RsettingsController@change_status')->name('change.status');
    });
    Route::get('reservation', 'ReservationsController@index')->name('reservation');
    Route::group(['prefix' => 'reservation', 'as'=>'reservation.'], function () {
        Route::post('datatable-data', 'ReservationsController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'ReservationsController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'ReservationsController@edit')->name('edit');
        Route::post('delete', 'ReservationsController@delete')->name('delete');
        Route::get('cancel', 'ReservationsController@cancel_list')->name('cancel');
        Route::post('cancel-datatable-data', 'ReservationsController@get_datatable_cancel_data')->name('cancel.datatable.data');
        Route::post('bulk-delete', 'ReservationsController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'ReservationsController@change_status')->name('change.status');
    });

    Route::get('fcpackage', 'CombopackagesController@index')->name('fcpackage');
    Route::group(['prefix' => 'fcpackage', 'as'=>'fcpackage.'], function () {
        Route::post('datatable-data', 'CombopackagesController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'CombopackagesController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'CombopackagesController@edit')->name('edit');
        Route::post('delete', 'CombopackagesController@delete')->name('delete');
        Route::get('cancel', 'CombopackagesController@cancel_list')->name('cancel');
        Route::post('cancel-datatable-data', 'CombopackagesController@get_datatable_cancel_data')->name('cancel.datatable.data');
        Route::post('bulk-delete', 'CombopackagesController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'CombopackagesController@change_status')->name('change.status');
    });
});
