<?php

use App\Http\Controllers\Admin\MrAdminBackUpController;
use App\Http\Controllers\Helpers\MrMessageHelper;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Auth::routes();

Route::get('locale/{locale}', function ($locale) {
  Session::put('locale', $locale);
  return redirect()->back();
});

Route::get('/', 'HomeController@index')->name('welcome');
Route::match(['get', 'post'], '/faq', 'MrFAQController@index');

Route::get('/policy', 'MrArticlesController@ViewPolicy');
Route::get('/api', 'MrArticlesController@ViewApi');

// атворизация через соц сети
Route::post('/ulogin', 'UloginController@login');

// Подписка
Route::match(['get', 'post'], '/subscription', "MrSubscriptionController@Subscription");
Route::match(['get', 'post'], '/unsubscription/{token}', "MrSubscriptionController@UnSubscription");
Route::post('/feedback', "MrFAQController@Feedback");

//// Справочники
Route::get('/references', 'MrReferences@List');
Route::get('/reference/{name}', 'MrReferences@View');

// Поиск
Route::match(['get', 'post'], '/search', 'MrApiController@Search')->name('search');

// Страница инфо о сертификате
Route::get('/certificate/{number}', 'MrCertificateController@View');


//// для авторизованных
Route::group(['middleware' => 'auth'], function () {

  //// Кабинет пользователя
  Route::get('/office', "Office\MrOfficeController@officePage")->name('office_page');
  Route::get('/office/settings', "Office\MrOfficeController@settingsPage")->name('office_settings_page');
  Route::get('/office/finance', "Office\MrOfficeController@financePage")->name('office_finance_page');
  Route::post('/office/personal/edit', "Office\MrUserController@Edit")->name('data_user_edit');

  //// Удаление аккаунта
  Route::match(['get', 'post'], '/office/delete/', "Forms\MrUserDeleteForm@builderForm")->name('user_delete');
  Route::match(['get', 'post'], '/office/delete/submit', "Forms\MrUserDeleteForm@submitForm");
});


//// для Админа
Route::group(['middleware' => 'is_admin'], function () {

  Route::get('/test', "MrTestController@index");
  //// Админка

  // BACK UP
  Route::get('/admin/hardware/backup', "Admin\MrAdminBackUpController@index")->name('admin_backup_list');

  Route::get('/admin/hardware/backup/refresh/{table_name}', function ($table_name) {
    Artisan::call('migrate:refresh --path=/database/migrations/' . $table_name . '.php');
    Cache::forget(MrAdminBackUpController::getTableNameFromFileName($table_name) . '_count_rows');
    MrMessageHelper::SetMessage(true, "Таблица {$table_name} переустановлена");
    return back();
  })->name('migration_refresh_table');

  Route::get('/admin/hardware/backup/save/{table_name}', "Admin\MrAdminBackUpController@SaveDataFromTable")->name('save_table_data');
  Route::get('/admin/hardware/backup/recovery/{table_name}', "Admin\MrAdminBackUpController@RecoveryDataToTable")->name('recovery_table_data');


  Route::get('/admin/hardware/backup/migrate/', function () {
    Artisan::call('migrate');
    return back();
  })->name('artisan_migrate');


  Route::get('/admin', "Admin\MrAdminController@index")->name('admin');
  // FAQ
  Route::match(['get', 'post'], '/admin/faq', "Admin\MrAdminFaqController@list")->name('faq');
  Route::match(['get', 'post'], '/admin/faq/edit/{id}', "Admin\MrAdminFaqController@edit")->name('edit_faq');
  Route::get('/admin/faq/delete/{id}', "Admin\MrAdminFaqController@delete")->name('delete_faq');

  // Статьи
  Route::get('/admin/articles', "Admin\MrAdminArticlesController@list")->name('article_list');
  Route::match(['get', 'post'], '/admin/article/edit/{id}', "Admin\MrAdminArticlesController@edit")->name('article_edit');
  Route::get('/admin/article/delete/{id}', "Admin\MrAdminArticlesController@delete")->name('article_delete');

  // Сообщения от пользователей
  Route::get('/admin/feedback', "Admin\MrAdminFeedbackController@List")->name('admin_feedback_list');
  Route::get('/admin/feedback/edit/{id}', "Admin\MrAdminFeedbackController@edit")->name('admin_feedback_edit');
  Route::get('/admin/feedback/edit/read/{id}',
    "Admin\MrAdminFeedbackController@read")->name('admin_feedback_read');
  Route::match(['get', 'post'], '/admin/feedback/edit/send/{id}',
    "Admin\MrAdminFeedbackController@send")->name('admin_feedback_send');
  Route::get('/admin/feedback/delete/{id}', "Admin\MrAdminFeedbackController@delete")->name('delete_faq');
  // Пользователи
  Route::get('/admin/users', "Admin\MrAdminUsersController@index")->name('users');
  Route::get('/admin/users/unblock/{id}', "Admin\MrAdminUsersController@unblock")->name('users_unblock');
  Route::get('/admin/users/block', "Admin\MrAdminUsersController@setUserBlock")->name('user_block');
  Route::get('/admin/users/delete/{id}', "Admin\MrAdminController@userDeleteForever")->name('user_delete_forever');

  Route::match(['get', 'post'], '/admin/users/edit/{id}/submit', "Forms\Admin\MrUserEditForm@submitForm")->name('user_form_submit');
  Route::match(['get', 'post'], '/admin/users/edit/{id}', "Forms\Admin\MrUserEditForm@getFormBuilder")->name('user_form_edit');

  // Подписка
  Route::get('/admin/subscription', "Admin\MrAdminSubscription@index")->name('admin_subscription');
  Route::get('/admin/subscription/delete/{id}',
    "Admin\MrAdminSubscription@UnSubscription")->name('un_subscription');
  Route::post('/admin/subscription/new', "Admin\MrAdminSubscription@NewSubscription")->name('new_subscription');
  // Текстовый редактор
  Route::get('/elfinder/ckeditor', '\Barryvdh\Elfinder\ElfinderController@showCKeditor4');
  Route::any('/elfinder/connector', '\Barryvdh\Elfinder\ElfinderController@showConnector')->name('elfinder.connector');
  // Логи, железо
  Route::get('/admin/hardware', "Admin\MrAdminHardwareController@index")->name('mir_logs');
  Route::post('/admin/hardware/api', "Admin\MrAdminHardwareController@ApiUpdate")->name('mir_logs_api');
  Route::get('/admin/hardware/delete', "Admin\MrAdminHardwareController@DeleteLogIdent")->name('mir_logs_delete');
  Route::get('/admin/hardware/addbot', "Admin\MrAdminHardwareController@AddBot")->name('mir_logs_add_bot');
  Route::get('/admin/hardware/bot', "Admin\MrAdminHardwareController@botPage")->name('bot_page');
  Route::get('/admin/hardware/bot/delete/{id}', "Admin\MrAdminHardwareController@DelBot")->name('bot_del');
  Route::post('/admin/hardware/bot/add/{id}/{text}', "Admin\MrAdminHardwareController@AddBot")->name('bot_del');

  // Лог изменений БД
  Route::get('/admin/hardware/dblog', "Admin\MrAdminHardwareController@ViewDbLog")->name('db_log_list');
  Route::get('/admin/hardware/dblog/delete/{id}', "Admin\MrAdminHardwareController@deleteDbLog")->name('delete_bd_log');
  //// Перевод сайта на другие языки
  Route::get('/admin/language', "Admin\MrAdminLanguageController@List")->name('language_list');
  // Добавить новый язык
  Route::get('/admin/language/add', "Admin\MrAdminLanguageController@Add")->name('language_add');
  // Форма редактирования языка
  Route::match(['get', 'post'], '/admin/language/edit/{id}/submit', "Forms\Admin\MrAdminLanguageEditForm@submitForm")->name('admin_language_edit_submit');
  Route::match(['get', 'post'], '/admin/language/edit/{id}', "Forms\Admin\MrAdminLanguageEditForm@getFormBuilder")->name('admin_language_edit_form');
  // Удалить перевод слов(а)
  Route::get('/admin/language/word/{id}/delete', "Admin\MrAdminLanguageController@translatedWordDelete")->name('translate_word_delete');
  // Форма редактирования перевода
  Route::match(['get', 'post'], '/admin/language/word/edit/{id}/submit', "Forms\Admin\MrAdminTranslateWordEditForm@submitForm")->name('translate_word_submit');
  Route::match(['get', 'post'], '/admin/language/word/edit/{id}', "Forms\Admin\MrAdminTranslateWordEditForm@getFormBuilder")->name('translate_word_edit');
  //// Справочники
  // Удаление строки
  Route::get('/admin/reference/{name}/delete/{id}', "Admin\MrAdminReferences@DeleteForID");
  // Страны мира
  Route::get('/admin/reference/country', "Admin\MrAdminReferences@ViewCountry");
  // Переустановка справочника
  Route::get('/admin/reference/country/rebuild', "Admin\MrAdminReferences@RebuildCountry")->name('reference_country');
  // Форма редактирования справочника стран
  Route::match(['get', 'post'], '/admin/reference/country/edit/{id}/submit', "Forms\Admin\MrAdminReferenceCountryEditForm@submitForm")->name('admin_reference_country_form_submit');
  Route::match(['get', 'post'], '/admin/reference/country/edit/{id}', "Forms\Admin\MrAdminReferenceCountryEditForm@getFormBuilder")->name('admin_reference_country_form_edit');

  // Валюты мира
  Route::get('/admin/reference/currency', "Admin\MrAdminReferences@ViewCurrency");
  // Переустановка справочника
  Route::get('/admin/reference/currency/rebuild', "Admin\MrAdminReferences@RebuildCurrency")->name('reference_currency');
  // Форма редактирования справочника стран
  Route::match(['get', 'post'], '/admin/reference/currency/edit/{id}/submit', "Forms\Admin\MrAdminReferenceCurrencyEditForm@submitForm")->name('admin_reference_currency_form_submit');
  Route::match(['get', 'post'], '/admin/reference/currency/edit/{id}', "Forms\Admin\MrAdminReferenceCurrencyEditForm@getFormBuilder")->name('admin_reference_currency_form_edit');

  //// Проект СЕРТИФИКАТЫ СООТВЕТСТВИЯ
  Route::get('/admin/certificate', "Admin\MrAdminCertificateController@View");
  Route::get('/admin/certificate/details/{id}', "Admin\MrAdminCertificateController@CertificateDetails");
  // Форма редактированиея сведения о сертификате
  Route::match(['get', 'post'], '/admin/certificate/{certificate_id}/details/edit/{id}/submit', "Forms\Admin\MrAdminCertificateDetailsEditForm@submitForm")->name('admin_certificate_details_form_submit');
  Route::match(['get', 'post'], '/admin/certificate/{certificate_id}/details/edit/{id}', "Forms\Admin\MrAdminCertificateDetailsEditForm@getFormBuilder")->name('admin_certificate_details_form_edit');
  // Форма добавления нового сертификата
  Route::match(['get', 'post'], '/admin/certificate/edit/{id}/submit', "Forms\Admin\MrAdminCertificateEditForm@submitForm")->name('admin_certificate_form_submit');
  Route::match(['get', 'post'], '/admin/certificate/edit/{id}', "Forms\Admin\MrAdminCertificateEditForm@getFormBuilder")->name('admin_certificate_form_edit');
  // Удалить сертификат
  Route::get('/admin/certificate/delete/{id}', "Admin\MrAdminCertificateController@certificateDelete");
  Route::get('/admin/certificate/{certificate_id}/details/delete/{id}', "Admin\MrAdminCertificateController@certificateDetailsDelete");

  //// Офисы
  Route::get('/admin/offices', "Admin\MrAdminOfficeController@List")->name('admin_offices');
  Route::get('/admin/office/{id}', "Admin\MrAdminOfficeController@OfficePage")->name('admin_office_page');
  Route::get('/admin/office/delete/{id}', "Admin\MrAdminOfficeController@officeDelete")->name('office_delete');
  // Форма для создания пустого офиса
  Route::match(['get', 'post'], '/admin/office/edit/{id}/submit', "Forms\Admin\MrAdminOfficeEditForm@submitForm")->name('office_submit');
  Route::match(['get', 'post'], '/admin/office/edit/{id}', "Forms\Admin\MrAdminOfficeEditForm@getFormBuilder")->name('office_edit');
  // форма для редактирования почтовых данных офиса
  Route::match(['get', 'post'], '/admin/office/po/details/edit/{id}/submit', "Forms\Admin\MrAdminOfficePostDetailsEditForm@submitForm")->name('office_po_details_submit');
  Route::match(['get', 'post'], '/admin/office/po/details/edit/{id}', "Forms\Admin\MrAdminOfficePostDetailsEditForm@getFormBuilder")->name('office_po_details_edit');
  // форма для редактирования юридических данных офиса
  Route::match(['get', 'post'], '/admin/office/ur/details/edit/{id}/submit', "Forms\Admin\MrAdminOfficeURDetailsEditForm@submitForm")->name('office_ur_details_submit');
  Route::match(['get', 'post'], '/admin/office/ur/details/edit/{id}', "Forms\Admin\MrAdminOfficeURDetailsEditForm@getFormBuilder")->name('office_ur_details_edit');


  // Добавление тарифа для офиса
  Route::match(['get', 'post'], '/admin/office/edit_office_tariffs/edit/{id}/submit', "Forms\Admin\MrAdminOfficeTariffEditForm@submitForm")->name('office_tariffs_submit');
  Route::match(['get', 'post'], '/admin/office/edit_office_tariffs/edit/{id}', "Forms\Admin\MrAdminOfficeTariffEditForm@getFormBuilder")->name('office_tariffs_edit');
  Route::get('/admin/office/tariffinoffice/{id}/delete/', "Admin\MrAdminOfficeController@tariffOfficeDelete")->name('tariff_office_delete');

  // Добавление пользователя в ВО
  Route::match(['get', 'post'], '/admin/office/officeuser/edit/{id}/submit', "Forms\Admin\MrAdminOfficeUserEditForm@submitForm")->name('office_user_submit');
  Route::match(['get', 'post'], '/admin/office/officeuser/edit/{id}', "Forms\Admin\MrAdminOfficeUserEditForm@getFormBuilder")->name('office_user_edit');
  Route::get('/admin/office/userinoffice/{id}/delete', "Admin\MrAdminOfficeController@userOfficeDelete")->name('user_office_delete');
  Route::get('/admin/office/userinoffice/{id}/isadmin', "Admin\MrAdminOfficeController@userOfficeIsAdmin")->name('user_office_toggle_admin');

  // Тарифы
  Route::get('/admin/tariffs', "Admin\MrAdminTariffController@List")->name('tariffs');
  Route::get('/admin/tariff/delete/{id}', "Admin\MrAdminTariffController@tariffDelete")->name('tariff_delete');
  Route::match(['get', 'post'], '/admin/tariff/edit/{id}/submit', "Forms\Admin\MrAdminTariffEditForm@submitForm")->name('tariff_submit');
  Route::match(['get', 'post'], '/admin/tariff/edit/{id}', "Forms\Admin\MrAdminTariffEditForm@getFormBuilder")->name('tariff_edit');

  // Скидки
  Route::get('/admin/discount/delete/{id}', "Admin\MrAdminOfficeController@discountDelete")->name('discount_delete');
  Route::match(['get', 'post'], '/admin/office/{office_id}/discount/edit/{id}/submit', "Forms\Admin\MrAdminOfficeDiscountEditForm@submitForm")->name('office_discount_submit');
  Route::match(['get', 'post'], '/admin/office/{office_id}/discount/edit/{id}', "Forms\Admin\MrAdminOfficeDiscountEditForm@getFormBuilder")->name('office_discount_edit');
});


//// Системные
Route::get('/clear', function () {
  Artisan::call('cache:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  Artisan::call('route:clear');

  return back();
});

//// 404
Route::get('{all}', 'MrError404Controller@indexView')->name('404');
