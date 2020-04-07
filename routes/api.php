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
Route::match(['get', 'post'],'/reference/country_table', 'MrReferencesController@ListCountries')->name('list_country_table');
Route::match(['get', 'post'], '/reference/currency_table', 'MrReferencesController@ListCurrency')->name('list_currency_table');
Route::match(['get', 'post'], '/admin/system/backup/table/{table_name}', 'Admin\MrAdminBackUpController@GetTable')->name('list_db_table_table');


////