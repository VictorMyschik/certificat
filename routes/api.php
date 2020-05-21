<?php

use Illuminate\Support\Facades\Route;

//// Справочники
Route::match(['get', 'post'], '/reference/country_table', 'MrReferencesController@ListCountries')->name('list_country_table');
Route::match(['get', 'post'], '/reference/currency_table', 'MrReferencesController@ListCurrency')->name('list_currency_table');
Route::match(['get', 'post'], '/reference/measure_table', 'MrReferencesController@ListMeasure')->name('list_measure_table');
Route::match(['get', 'post'], '/reference/certificate_kind', 'MrReferencesController@ListCertificateKind')->name('list_certificate_kind_table');
Route::match(['get', 'post'], '/reference/technical_regulation', 'MrReferencesController@ListTechnicalRegulation')->name('list_technical_regulation_table');
Route::match(['get', 'post'], '/reference/technical_reglament', 'MrReferencesController@ListTechnicalReglament')->name('list_technical_reglament_table');

// BackUp
Route::match(['get', 'post'], '/admin/system/backup/table/{table_name}', 'Admin\MrAdminBackUpController@GetTable')->name('list_db_table_table');

// Certificates
Route::match(['get', 'post'], '/admin/certificate/certificate', 'Admin\MrAdminCertificateController@CertificateList')->name('list_certificate_table');
Route::match(['get', 'post'], '/admin/certificate/communicate', 'Admin\MrAdminCertificateController@CommunicateList')->name('list_communicate_table');
Route::match(['get', 'post'], '/admin/certificate/manufacturer', 'Admin\MrAdminCertificateController@ManufacturerList')->name('list_manufacturer_table');
Route::match(['get', 'post'], '/admin/certificate/address', 'Admin\MrAdminCertificateController@AddressList')->name('list_address_table');
Route::match(['get', 'post'], '/admin/certificate/fio', 'Admin\MrAdminCertificateController@FioList')->name('list_fio_table');
Route::match(['get', 'post'], '/admin/certificate/authority', 'Admin\MrAdminCertificateController@AuthorityList')->name('list_authority_table');
Route::match(['get', 'post'], '/admin/certificate/documents', 'Admin\MrAdminCertificateController@DocumentList')->name('list_document_table');
Route::match(['get', 'post'], '/admin/certificate/applicant', 'Admin\MrAdminCertificateController@ApplicantList')->name('list_applicant_table');
Route::match(['get', 'post'], '/admin/certificate/product_info', 'Admin\MrAdminCertificateController@ProductInfoList')->name('list_product_info_table');


//// Прочее
//Страница бэкапа с миграциями
Route::match(['get', 'post'], '/admin/system/backup/summary_table', 'Admin\MrAdminBackUpController@getSummaryList')->name('summary_list_table');

/// Для авторизованных
Route::group(['middleware' => 'auth'], function () {
  Route::match(['get', 'post'], '/watch/list', 'Office\MrOfficeController@CertificateMonitoringList')->name('list_certificate_monitoring');
  Route::match(['get', 'post'], '/search/user-history/{search_query}', 'Office\MrOfficeController@SetUserSearchHistory')
    ->name('set_user_search_history');
});

/// Для Админов
Route::group(['middleware' => 'is_admin'], function () {
  Route::match(['get', 'post'], '/admin/systemdata', 'Admin\MrAdminController@GetData')->name('admin_redis_data');
  Route::match(['get', 'post'], '/admin/system/table', 'Admin\MrAdminSystemController@GetLogIdentTable')->name('admin_system_table');
  Route::match(['get', 'post'], '/admin/system/dblog/table', 'Admin\MrAdminSystemController@GetDbLogTable')->name('admin_db_log_table');
  Route::match(['get', 'post'], '/admin/language/word/table', 'Admin\MrAdminLanguageController@GetTranslateTable')->name('admin_translate_word_table');
  Route::match(['get', 'post'], '/admin/faq/table', 'Admin\MrAdminFaqController@GetFaqTable')->name('admin_faq_table');
  Route::match(['get', 'post'], '/admin/feedback/table', 'Admin\MrAdminFeedbackController@GetFeedbackTable')->name('admin_feedback_table');
  Route::match(['get', 'post'], '/admin/article/table', 'Admin\MrAdminArticlesController@GetArticleTable')->name('admin_article_table');
  Route::match(['get', 'post'], '/admin/subscription/table', 'Admin\MrAdminSubscriptionController@GetSubscriptionTable')->name('admin_subscription_table');
  Route::match(['get', 'post'], '/admin/email/table', 'Admin\MrAdminEmailController@GetEmailTable')->name('admin_email_table');

  // Офис
  Route::match(['get', 'post'], '/admin/offices/table', 'Admin\MrAdminOfficeController@GetOfficeTable')->name('admin_offices_table');

});