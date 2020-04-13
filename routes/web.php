<?php

use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Admin\MrAdminBackUpController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Auth::routes(['verify' => true]);

Route::get('locale/{locale}', function ($locale) {
  Session::put('locale', $locale);
  return redirect()->back();
});

Route::get('/', 'HomeController@index')->name('welcome');
Route::match(['get', 'post'], '/faq', 'MrFAQController@index')->name('faq_page');

Route::get('/policy', 'MrArticlesController@ViewPolicy')->name('policy_page');
Route::get('/api', 'MrArticlesController@ViewApi');

// Подписка
Route::match(['get', 'post'], '/subscription', "MrSubscriptionController@Subscription");
Route::match(['get', 'post'], '/unsubscription/{token}', "MrSubscriptionController@UnSubscription");
Route::post('/feedback', "MrFAQController@Feedback")->name('feedback');

//// Справочники
/// универсальная динамческая страница справочкика
Route::get('/references/{name}', 'MrReferencesController@View')->name('references');

Route::post('/certificates', 'MrCertificateController@List')->name('certificates_list');

// Поиск
Route::match(['get', 'post'], '/search', 'MrApiController@Search')->name('search');

// Страница инфо о сертификате
Route::get('/certificate/{number}', 'MrCertificateController@View');


Route::get('/newuser/{string}', 'MrNewUserController@RegistrationNewUser')->name('registration_new_user');

// Приём данных с Telegram
Route::match(['get', 'post'], '/telegram/webhook', 'MrApiController@TelegramWebHook')->name('telegram_web_hook');

//// для авторизованных
Route::group(['middleware' => ['auth', 'verified']], function () {
  Route::match(['get', 'post'], '/users/edit/{id}/submit', "Forms\MrUserEditForm@submitForm")->name('user_form_submit');
  Route::match(['get', 'post'], '/users/edit/{id}', "\App\Forms\MrUserEditForm@getFormBuilder")->name('user_form_edit');

  // Личная страница
  Route::get('/personal', "Office\MrUserController@PersonalPage")->name('personal_page');

  //// Кабинет пользователя
  Route::get('/office/{office_id}', "Office\MrOfficeController@officePage")->name('office_page');
  Route::get('/office/{office_id}/settings', "Office\MrOfficeController@settingsPage")->name('office_settings_page');

  // форма для редактирования почтовых данных офиса
  Route::match(['get', 'post'], '/admin/office/{id}/po/details/edit/submit', "Forms\Admin\MrAdminOfficePostDetailsEditForm@submitForm")->name('office_po_details_submit');
  Route::match(['get', 'post'], '/admin/office/{id}/po/details/edit', "Forms\Admin\MrAdminOfficePostDetailsEditForm@getFormBuilder")->name('office_po_details_edit');

  // форма для редактирования юридических данных офиса
  Route::match(['get', 'post'], '/admin/office/{id}/ur/details/edit/submit', "Forms\Admin\MrAdminOfficeURDetailsEditForm@submitForm")->name('office_ur_details_submit');
  Route::match(['get', 'post'], '/admin/office/{id}/ur/details/edit', "Forms\Admin\MrAdminOfficeURDetailsEditForm@getFormBuilder")->name('office_ur_details_edit');

  // Смена статуса пользователя в офисе
  Route::get('/office/{office_id}/userinoffice/{id}/isadmin', "Office\MrOfficeController@userOfficeIsAdmin")->name('user_office_toggle_admin');
  // Смена статуса приглашённого пользователя
  Route::get('/office/{office_id}/newuserinoffice/{id}/isadmin', "Office\MrOfficeController@NewUserOfficeIsAdmin")->name('new_user_office_toggle_admin');


  // Добавление нового пользователя
  Route::match(['get', 'post'], 'office/{office_id}/user/edit/{id}/submit', "Forms\MrAddOfficeUserForm@submitForm")->name('add_office_user_submit');
  Route::match(['get', 'post'], 'office/{office_id}/user/edit/{id}', "Forms\MrAddOfficeUserForm@getFormBuilder")->name('add_office_user_edit');

  // Переотправить письмо со ссылкой для приглашённого пользователя
  Route::get('/office/{new_user_id}/resend', "Office\MrUserController@ResendForNewUser")->name('resend_message_for_new_user');

  //// Telegram Оповещение
  //Форма добавления нового аккаунта телеграм
  Route::match(['get', 'post'], 'personal/telegram/edit/{id}/submit', "Forms\User\MrUserTelegramEditForm@submitForm")->name('user_telegram_submit');
  Route::match(['get', 'post'], 'personal/telegram/edit/{id}', "Forms\User\MrUserTelegramEditForm@getFormBuilder")->name('user_telegram_edit');


  //// Удаление пользователя из ВО
  Route::get('/office/userinoffice/{id}/delete/', "Office\MrOfficeController@UserInOfficeDelete")->name('user_in_office_delete');
  // Себя
  Route::get('/user/delete/', "Office\MrUserController@DeleteSelf")->name('self_delete');

  // подписка пользователя
  Route::get('/toggle_subscription', "Office\MrUserController@ToggleSubscription")->name('toggle_subscription');
  // Удалить приглашённого пользователя
  Route::get('/office/{office_id}/new_user/{id}/delete', "Office\MrOfficeController@NewUserDelete")->name('new_user_delete');
});


//// для Админа
Route::group(['middleware' => 'is_admin'], function () {

  Route::match(['get', 'post'], '/test', "MrTestController@index")->name('admin_test');

  Route::get('/admin', "Admin\MrAdminController@index")->name('admin_page');
  // FAQ
  Route::match(['get', 'post'], '/admin/faq', "Admin\MrAdminFaqController@list")->name('admin_faq_page');
  Route::match(['get', 'post'], '/admin/faq/edit/{id}', "Admin\MrAdminFaqController@edit")->name('admin_faq_edit');
  Route::get('/admin/faq/delete/{id}', "Admin\MrAdminFaqController@delete")->name('admin_faq_delete');

  // Статьи
  Route::get('/admin/articles', "Admin\MrAdminArticlesController@list")->name('admin_article_page');
  Route::match(['get', 'post'], '/admin/article/edit/{id}', "Admin\MrAdminArticlesController@edit")->name('admin_article_edit');
  Route::get('/admin/article/delete/{id}', "Admin\MrAdminArticlesController@delete")->name('admin_article_delete');

  // Сообщения от пользователей
  Route::get('/admin/feedback', "Admin\MrAdminFeedbackController@List")->name('admin_feedback_list');
  Route::get('/admin/feedback/edit/{id}', "Admin\MrAdminFeedbackController@edit")->name('admin_feedback_edit');
  Route::get('/admin/feedback/edit/read/{id}',
    "Admin\MrAdminFeedbackController@read")->name('admin_feedback_read');
  Route::match(['get', 'post'], '/admin/feedback/edit/send/{id}',
    "Admin\MrAdminFeedbackController@send")->name('admin_feedback_send');
  Route::get('/admin/feedback/delete/{id}', "Admin\MrAdminFeedbackController@delete")->name('delete_faq');


  // Пользователи
  Route::get('/admin/users', "Admin\MrAdminUsersController@index")->name('admin_users');
  Route::get('/admin/users/unblock/{id}', "Admin\MrAdminUsersController@unblock")->name('users_unblock');
  Route::get('/admin/users/block', "Admin\MrAdminUsersController@setUserBlock")->name('user_block');
  Route::get('/admin/users/delete/{id}', "Admin\MrAdminController@userDeleteForever")->name('user_delete_forever');

  // Подписка
  Route::get('/admin/subscription', "Admin\MrAdminSubscriptionController@index")->name('admin_subscription');
  Route::get('/admin/subscription/delete/{id}',
    "Admin\MrAdminSubscription@UnSubscription")->name('un_subscription');
  Route::post('/admin/subscription/new', "Admin\MrAdminSubscription@NewSubscription")->name('new_subscription');
  // Текстовый редактор
  Route::get('/elfinder/ckeditor', '\Barryvdh\Elfinder\ElfinderController@showCKeditor4');
  Route::any('/elfinder/connector', '\Barryvdh\Elfinder\ElfinderController@showConnector')->name('elfinder.connector');


  //// Логи, железо
  Route::get('/admin/system', "Admin\MrAdminSystemController@index")->name('admin_logs');
  Route::post('/admin/system/api', "Admin\MrAdminSystemController@ApiUpdate")->name('admin_logs_api');
  Route::get('/admin/system/delete', "Admin\MrAdminSystemController@DeleteLogIdent")->name('admin_logs_delete');
  // Лог изменений БД
  Route::get('/admin/system/dblog', "Admin\MrAdminSystemController@ViewDbLog")->name('admin_db_log_page');
  Route::get('/admin/system/dblog/delete/{id}', "Admin\MrAdminSystemController@deleteDbLog")->name('delete_bd_log');
  //// Перевод сайта на другие языки
  Route::get('/admin/language', "Admin\MrAdminLanguageController@List")->name('admin_language_list');
  // Добавить новый язык
  Route::get('/admin/language/add', "Admin\MrAdminLanguageController@Add")->name('admin_language_add');
  // Форма редактирования языка
  Route::match(['get', 'post'], '/admin/language/edit/{id}/submit', "\App\Forms\Admin\MrAdminLanguageEditForm@submitForm")->name('admin_language_edit_submit');
  Route::match(['get', 'post'], '/admin/language/edit/{id}', "\App\Forms\Admin\MrAdminLanguageEditForm@getFormBuilder")->name('admin_language_edit_form');
  // Удалить перевод слов(а)
  Route::get('/admin/language/word/{id}/delete', "Admin\MrAdminLanguageController@translatedWordDelete")->name('translate_word_delete');
  // Форма редактирования перевода
  Route::match(['get', 'post'], '/admin/language/word/edit/{id}/submit', "\App\Forms\Admin\MrAdminTranslateWordEditForm@submitForm")->name('translate_word_submit');
  Route::match(['get', 'post'], '/admin/language/word/edit/{id}', "\App\Forms\Admin\MrAdminTranslateWordEditForm@getFormBuilder")->name('translate_word_edit');


  //// BACK UP
  Route::get('/admin/system/backup/refresh/{table_name}', function ($table_name) {
    Artisan::call('migrate:refresh --path=/database/migrations/' . $table_name . '.php');
    Cache::forget(MrAdminBackUpController::getTableNameFromFileName($table_name) . '_count_rows');
    MrMessageHelper::SetMessage(true, "Таблица {$table_name} переустановлена");
    return back();
  })->name('migration_refresh_table');
  Route::get('/admin/system/backup/{table_name}', "Admin\MrAdminBackUpController@ViewTable")->name('admin_view_table_page');
  Route::get('/admin/system/backup', "Admin\MrAdminBackUpController@index")->name('admin_backup_page');
  Route::get('/admin/system/backup/save/{table_name}', "Admin\MrAdminBackUpController@SaveDataFromTable")->name('save_table_data');
  Route::get('/admin/system/backup/recovery/{table_name}', "Admin\MrAdminBackUpController@RecoveryDataToTable")->name('recovery_table_data');

  Route::get('/admin/system/backup/run/migrate/', function () {
    Artisan::call('migrate');
    return back();
  })->name('artisan_migrate');


  //// Справочники
  // Удаление строки
  Route::get('/admin/reference/{name}/delete/{id}', "Admin\MrAdminReferences@DeleteForID")->name('reference_item_delete');

  //// Страны мира
  Route::get('/admin/reference/country', "Admin\MrAdminReferences@ViewCountry")->name('admin_country_page');
  // Edit
  Route::match(['get', 'post'], '/admin/reference/country/edit/{id}/submit', "\App\Forms\Admin\MrAdminReferenceCountryEditForm@submitForm")->name('admin_reference_country_form_submit');
  Route::match(['get', 'post'], '/admin/reference/country/edit/{id}', "\App\Forms\Admin\MrAdminReferenceCountryEditForm@getFormBuilder")->name('admin_reference_country_form_edit');

  //// Валюты мира
  Route::get('/admin/reference/currency', "Admin\MrAdminReferences@ViewCurrency")->name('admin_currency_page');
  // Форма редактирования справочника Валют
  Route::match(['get', 'post'], '/admin/reference/currency/edit/{id}/submit', "\App\Forms\Admin\MrAdminReferenceCurrencyEditForm@submitForm")->name('admin_reference_currency_form_submit');
  Route::match(['get', 'post'], '/admin/reference/currency/edit/{id}', "\App\Forms\Admin\MrAdminReferenceCurrencyEditForm@getFormBuilder")->name('admin_reference_currency_form_edit');


  #region СЕРТИФИКАТЫ СООТВЕТСТВИЯ
  Route::get('/admin/certificate', "Admin\MrAdminCertificateController@View");
  // Удалить сертификат
  Route::get('/admin/certificate/delete/{id}', "Admin\MrAdminCertificateController@certificateDelete");

  // Email Phone...
  Route::get('/admin/certificate/communicate', "Admin\MrAdminCertificateController@ViewCommunicate")->name('communicate_page');
  // Производители
  Route::get('/admin/certificate/manufacturer', "Admin\MrAdminCertificateController@ViewManufacturer")->name('manufacturer_page');
  Route::get('/admin/certificate/manufacturer/delete/{id}', "Admin\MrAdminCertificateController@ManufacturerDelete")->name('manufacturer_delete');

  // Загрузка из XML
  Route::match(['get', 'post'], '/admin/certificate/manufacturer/load/submit', "\App\Forms\Admin\MrCertificateManufacturerLoadForm@submitForm")->name('admin_manufacturer_load_submit');
  Route::match(['get', 'post'], '/admin/certificate/manufacturer/load/', "\App\Forms\Admin\MrCertificateManufacturerLoadForm@getFormBuilder")->name('admin_manufacturer_load_edit');


  #endregion

  //// Офисы
  Route::get('/admin/offices', "Admin\MrAdminOfficeController@List")->name('admin_offices');
  Route::get('/admin/office/{id}', "Admin\MrAdminOfficeController@OfficePage")->name('admin_office_page');
  Route::get('/admin/office/delete/{id}', "Admin\MrAdminOfficeController@officeDelete")->name('office_delete');

  // Форма для создания пустого офиса
  Route::match(['get', 'post'], '/admin/office/edit/{id}/submit', "\App\Forms\Admin\MrOfficeEditForm@submitForm")->name('admin_office_submit');
  Route::match(['get', 'post'], '/admin/office/edit/{id}', "\App\Forms\Admin\MrOfficeEditForm@getFormBuilder")->name('admin_office_edit');

  // Добавление тарифа для офиса
  Route::match(['get', 'post'], '/admin/office/edit_office_tariffs/edit/{id}/submit', "Forms\MrOfficeTariffEditForm@submitForm")->name('office_tariffs_submit');
  Route::match(['get', 'post'], '/admin/office/edit_office_tariffs/edit/{id}', "Forms\MrOfficeTariffEditForm@getFormBuilder")->name('office_tariffs_edit');
  Route::get('/admin/office/{office_id}/tariffinoffice/{id}/delete/', "Admin\MrAdminOfficeController@tariffOfficeDelete")->name('tariff_office_delete');

  // Добавление пользователя в ВО
  Route::get('/admin/office/userinoffice/{id}/delete', "Admin\MrAdminOfficeController@userOfficeDelete")->name('user_office_delete');


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
  Log::debug('CLEARED');
  Artisan::call('cache:clear');
  Artisan::call('view:clear');
  Artisan::call('route:clear');
  Artisan::call('route:clear');
//composer dump-autoload --optimize
  return back();
})->name('clear');

//// 404
Route::get('{all}', 'MrError404Controller@indexView')->name('404');
