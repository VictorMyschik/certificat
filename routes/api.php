<?php

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

//// Справочники
Route::match(['get', 'post'], '/reference/country_table', 'MrReferencesController@ListCountries')->name('list_country_table');
Route::match(['get', 'post'], '/reference/currency_table', 'MrReferencesController@ListCurrency')->name('list_currency_table');

// BackUp
Route::match(['get', 'post'], '/admin/system/backup/table/{table_name}', 'Admin\MrAdminBackUpController@GetTable')->name('list_db_table_table');

// Certificates
Route::match(['get', 'post'], '/admin/certificate/communicate', 'MrAdminCertificateController@CommunicateList')->name('list_communicate_table');



//// Прочее
//Страница бэкапа с миграциями
Route::match(['get', 'post'], '/admin/system/backup/summary_table', 'Admin\MrAdminBackUpController@getSummaryList')->name('summary_list_table');

/// Для Админов
Route::group(['middleware' => 'is_admin'], function () {
  Route::match(['get', 'post'], '/admin/systemdata', 'Admin\MrAdminController@GetData')->name('admin_redis_data');

});