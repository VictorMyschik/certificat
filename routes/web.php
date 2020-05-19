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
/// универсальная динамическая страница справочника
Route::get('/references/{name}', 'MrReferencesController@View')->name('references');

// Страница инфо о сертификате
Route::get('/certificate/{number}', 'MrCertificateController@View');


Route::POST('/newuser/{string}/register', 'MrNewUserController@RegNewUser')->name('new_user_register');
Route::get('/newuser/{string}', 'MrNewUserController@RegistrationNewUser')->name('registration_new_user');

// Приём данных с Telegram
Route::match(['get', 'post'], '/telegram/webhook', 'MrApiController@TelegramWebHook')->name('telegram_web_hook');

//// для авторизованных
Route::group(['middleware' => ['auth', 'verified']], function () {
  #region Personal
  Route::match(['get', 'post'], '/users/edit/{id}/submit', "\App\Forms\MrUserEditForm@submitForm")->name('user_form_submit');
  Route::match(['get', 'post'], '/users/edit/{id}', "\App\Forms\MrUserEditForm@getFormBuilder")->name('user_form_edit');

  // Личная страница
  Route::get('/personal', "Office\MrUserController@PersonalPage")->name('personal_page');
  #endregion

  #region Office

  // Форма редактирования офиса
  Route::match(['get', 'post'], '/office/{office_id}/edit/submit', "\App\Forms\Admin\MrOfficeEditForm@submitForm")->name('admin_office_submit');
  Route::match(['get', 'post'], '/office/{office_id}/edit', "\App\Forms\Admin\MrOfficeEditForm@getFormBuilder")->name('admin_office_edit');

  // Добавление пользователя в ВО
  Route::get('/office/userinoffice/{id}/delete', "Admin\MrAdminOfficeController@userOfficeDelete")->name('user_office_delete');
  #endregion

  //// Кабинет пользователя
  Route::get('/office', "Office\MrOfficeController@officePageDefault")->name('office_page_default');
  Route::get('/office/{office_id}', "Office\MrOfficeController@officePage")->name('office_page');
  Route::get('/office/{office_id}/settings', "Office\MrOfficeController@settingsPage")->name('office_settings_page');

  // форма для редактирования почтовых данных офиса
  Route::match(['get', 'post'], '/office/{office_id}/po/details/edit/submit', "\App\Forms\Admin\MrAdminOfficePostDetailsEditForm@submitForm")->name('office_po_details_submit');
  Route::match(['get', 'post'], '/office/{office_id}/po/details/edit', "\App\Forms\Admin\MrAdminOfficePostDetailsEditForm@getFormBuilder")->name('office_po_details_edit');

  // форма для редактирования юридических данных офиса
  Route::match(['get', 'post'], '/office/{office_id}/ur/details/edit/submit', "\App\Forms\Admin\MrAdminOfficeURDetailsEditForm@submitForm")->name('office_ur_details_submit');
  Route::match(['get', 'post'], '/office/{office_id}/ur/details/edit', "\App\Forms\Admin\MrAdminOfficeURDetailsEditForm@getFormBuilder")->name('office_ur_details_edit');

  // Смена статуса пользователя в офисе
  Route::get('/office/{office_id}/userinoffice/{id}/isadmin', "Office\MrOfficeController@userOfficeIsAdmin")->name('user_office_toggle_admin');
  // Смена статуса приглашённого пользователя
  Route::get('/office/{office_id}/newuserinoffice/{id}/isadmin', "Office\MrOfficeController@NewUserOfficeIsAdmin")->name('new_user_office_toggle_admin');


  // Добавление нового пользователя
  Route::match(['get', 'post'], 'office/{office_id}/user/edit/{id}/submit', "\App\Forms\MrAddOfficeUserForm@submitForm")->name('add_office_user_submit');
  Route::match(['get', 'post'], 'office/{office_id}/user/edit/{id}', "\App\Forms\MrAddOfficeUserForm@getFormBuilder")->name('add_office_user_edit');

  // Переотправить письмо со ссылкой для приглашённого пользователя
  Route::get('office/{office_id}/{new_user_id}/resend', "Office\MrOfficeController@ResendEmailForNewUser")->name('resend_message_for_new_user');

  //// Telegram Оповещение
  //Форма добавления нового аккаунта телеграмм
  Route::match(['get', 'post'], 'personal/telegram/edit/{id}/submit', "\App\Forms\User\MrUserTelegramEditForm@submitForm")->name('user_telegram_submit');
  Route::match(['get', 'post'], 'personal/telegram/edit/{id}', "\App\Forms\User\MrUserTelegramEditForm@getFormBuilder")->name('user_telegram_edit');


  //// Удаление пользователя из ВО
  Route::get('/office/userinoffice/{id}/delete/', "Office\MrOfficeController@UserInOfficeDelete")->name('user_in_office_delete');
  // Себя
  Route::get('/user/delete/', "Office\MrUserController@DeleteSelf")->name('self_delete');

  // подписка пользователя
  Route::get('/toggle_subscription', "Office\MrUserController@ToggleSubscription")->name('toggle_subscription');
  // Удалить приглашённого пользователя
  Route::get('/office/{office_id}/new_user/{id}/delete', "Office\MrOfficeController@NewUserDelete")->name('new_user_delete');


  //// Работа пользователя с сертификатами
  // Поиск
  Route::match(['get', 'post'], '/search/api', 'Office\MrOfficeController@SearchApi')->name('certificate_search');
  Route::match(['get', 'post'], '/search/api/get/{id}', 'Office\MrOfficeController@GetCertificate');

  // Добавление отслеживания
  Route::match(['get', 'post'], '/watch/add/{certificate_id}', 'Office\MrOfficeController@AddCertificateToMonitoring');

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

  // Почта
  Route::get('/admin/email', "Admin\MrAdminEmailController@List")->name('admin_emails_page');
  Route::get('/admin/email/{id}/delete', "Admin\MrAdminEmailController@EmailDelete")->name('admin_email_delete');
  // Почта инфо о письме
  Route::match(['get', 'post'], '/email/{id}/info/submit', "App\Forms\Admin\MrAdminEmailInfoForm@submitForm")->name('email_info_popup_submit');
  Route::match(['get', 'post'], '/email/{id}/info/', "App\Forms\Admin\MrAdminEmailInfoForm@getFormBuilder")->name('email_info_popup_edit');

  // Пользователи
  Route::get('/admin/users', "Admin\MrAdminUsersController@index")->name('admin_users');
  Route::get('/admin/users/unblock/{id}', "Admin\MrAdminUsersController@unblock")->name('users_unblock');
  Route::get('/admin/users/block', "Admin\MrAdminUsersController@setUserBlock")->name('user_block');
  Route::get('/admin/users/delete/{id}', "Admin\MrAdminController@userDeleteForever")->name('user_delete_forever');

  // Подписка
  Route::get('/admin/subscription', "Admin\MrAdminSubscriptionController@index")->name('admin_subscription');
  Route::get('/admin/subscription/delete/{id}', "Admin\MrAdminSubscriptionController@UnSubscription")->name('un_subscription');
  Route::post('/admin/subscription/new', "Admin\MrAdminSubscriptionController@NewSubscription")->name('new_subscription');
  // Текстовый редактор
  Route::get('/elfinder/ckeditor', '\Barryvdh\Elfinder\ElfinderController@showCKeditor4');
  Route::any('/elfinder/connector', '\Barryvdh\Elfinder\ElfinderController@showConnector')->name('elfinder.connector');


  //// Логи, железо
  Route::get('/admin/system', "Admin\MrAdminSystemController@index")->name('admin_logs');
  Route::post('/admin/system/api', "Admin\MrAdminSystemController@ApiUpdate")->name('admin_logs_api');
  Route::get('/admin/system/delete', "Admin\MrAdminSystemController@DeleteLogIdent")->name('admin_logs_delete');
  // Лог изменений БД
  Route::get('/admin/system/dblog', "Admin\MrAdminSystemController@ViewDbLog")->name('admin_db_log_page');
  Route::get('/admin/system/dblog/delete/{id}', "Admin\MrAdminSystemController@deleteDbLogRow")->name('admin_db_log_row_delete');
  Route::get('/admin/system/dblog/alldelete', "Admin\MrAdminSystemController@deleteDbLog")->name('delete_bd_log');
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
    MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, "Таблица {$table_name} переустановлена");
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
  Route::get('/admin/reference/{name}/delete/{id}', "Admin\MrAdminReferencesController@DeleteForID")->name('reference_item_delete');

  //// Классификатор стран
  Route::get('/admin/reference/country', "Admin\MrAdminReferencesController@ViewCountry")->name('admin_country_page');
  Route::match(['get', 'post'], '/admin/reference/country/edit/{id}/submit', "\App\Forms\Admin\MrAdminReferenceCountryEditForm@submitForm")->name('admin_reference_country_form_submit');
  Route::match(['get', 'post'], '/admin/reference/country/edit/{id}', "\App\Forms\Admin\MrAdminReferenceCountryEditForm@getFormBuilder")->name('admin_reference_country_form_edit');

  //// Классификатор валют
  Route::get('/admin/reference/currency', "Admin\MrAdminReferencesController@ViewCurrency")->name('admin_currency_page');
  Route::match(['get', 'post'], '/admin/reference/currency/edit/{id}/submit', "\App\Forms\Admin\MrAdminReferenceCurrencyEditForm@submitForm")->name('admin_reference_currency_form_submit');
  Route::match(['get', 'post'], '/admin/reference/currency/edit/{id}', "\App\Forms\Admin\MrAdminReferenceCurrencyEditForm@getFormBuilder")->name('admin_reference_currency_form_edit');

  //// Классификатор единиц измерения
  Route::get('/admin/reference/measure', "Admin\MrAdminReferencesController@ViewMeasure")->name('admin_measure_page');
  Route::match(['get', 'post'], '/admin/reference/measure/edit/{id}/submit', "\App\Forms\Admin\MrAdminMeasureEditForm@submitForm")->name('admin_reference_measure_form_submit');
  Route::match(['get', 'post'], '/admin/reference/measure/edit/{id}', "\App\Forms\Admin\MrAdminMeasureEditForm@getFormBuilder")->name('admin_reference_measure_form_edit');

  //// Классификатор видов документов об оценке соответствия
  Route::get('/admin/reference/certificate_kind', "Admin\MrAdminReferencesController@ViewCertificateKind")->name('admin_certificate_kind_page');
  Route::match(['get', 'post'], '/admin/reference/certificate_kind/edit/{id}/submit', "\App\Forms\Admin\MrAdminCertificateKindEditForm@submitForm")->name('admin_reference_certificate_kind_form_submit');
  Route::match(['get', 'post'], '/admin/reference/certificate_kind/edit/{id}', "\App\Forms\Admin\MrAdminCertificateKindEditForm@getFormBuilder")->name('admin_reference_certificate_kind_form_edit');

  //// Классификатор видов документов об оценке соответствия
  Route::get('/admin/reference/technical_regulation', "Admin\MrAdminReferencesController@ViewTechnicalRegulation")->name('admin_technical_regulation_page');
  Route::match(['get', 'post'], '/admin/reference/technical_regulation/edit/{id}/submit', "\App\Forms\Admin\MrAdminTechnicalRegulationEditForm@submitForm")->name('admin_reference_technical_regulation_form_submit');
  Route::match(['get', 'post'], '/admin/reference/technical_regulation/edit/{id}', "\App\Forms\Admin\MrAdminTechnicalRegulationEditForm@getFormBuilder")->name('admin_reference_technical_regulation_form_edit');

  //// Принятые технические регламенты
  Route::get('/admin/reference/technical_reglament', "Admin\MrAdminReferencesController@ViewTechnicalReglament")->name('admin_technical_reglament_page');
  Route::match(['get', 'post'], '/admin/reference/technical_reglament/edit/{id}/submit', "\App\Forms\Admin\MrAdminTechnicalReglamentEditForm@submitForm")->name('admin_reference_technical_reglament_form_submit');
  Route::match(['get', 'post'], '/admin/reference/technical_reglament/edit/{id}', "\App\Forms\Admin\MrAdminTechnicalReglamentEditForm@getFormBuilder")->name('admin_reference_technical_reglament_form_edit');


  #region СЕРТИФИКАТЫ СООТВЕТСТВИЯ
  Route::get('/admin/certificate', "Admin\MrAdminCertificateController@View")->name('admin_certificate_page');
  Route::get('/admin/certificate/details/{id}', "Admin\MrAdminCertificateController@ViewDetails")->name('admin_certificate_details');
  // Обновить
  Route::get('/admin/certificate/update/{id}', "Admin\MrAdminCertificateController@CertificateUpdate")->name('admin_certificate_update');
  // Загрузка сертификата по ссылке из сайта ЕАЭС или по идентификатору
  Route::post('/admin/certificate/updatefromurl', "Admin\MrAdminCertificateController@GetCertificateByURL")->name('admin_certificate_update_from_url');

  // Удалить сертификат
  Route::get('/admin/certificate/delete/{id}', "Admin\MrAdminCertificateController@certificateDelete")->name('admin_certificate_delete');

  // Email Phone...
  Route::get('/admin/certificate/communicate', "Admin\MrAdminCertificateController@ViewCommunicate")->name('admin_communicate_page');
  Route::get('/admin/certificate/communicate/delete/{id}', "Admin\MrAdminCertificateController@CommunicateDelete")->name('admin_communicate_delete');
  // Производители
  Route::get('/admin/certificate/manufacturer', "Admin\MrAdminCertificateController@ViewManufacturer")->name('admin_manufacturer_page');
  Route::get('/admin/certificate/manufacturer/delete/{id}', "Admin\MrAdminCertificateController@ManufacturerDelete")->name('admin_manufacturer_delete');
  // Адрес
  Route::get('/admin/certificate/address', "Admin\MrAdminCertificateController@ViewAddress")->name('admin_address_page');
  Route::get('/admin/certificate/address/delete/{id}', "Admin\MrAdminCertificateController@AddressDelete")->name('admin_address_delete');
  // ФИО
  Route::get('/admin/certificate/fio', "Admin\MrAdminCertificateController@ViewFio")->name('admin_fio_page');
  Route::get('/admin/certificate/fio/delete/{id}', "Admin\MrAdminCertificateController@FioDelete")->name('admin_fio_delete');
  // Органы по сертификации
  Route::get('/admin/certificate/authority', "Admin\MrAdminCertificateController@ViewAuthority")->name('admin_authority_page');
  Route::get('/admin/certificate/authority/delete/{id}', "Admin\MrAdminCertificateController@AuthorityDelete")->name('admin_authority_delete');
  // Документы
  Route::get('/admin/certificate/document', "Admin\MrAdminCertificateController@ViewDocument")->name('admin_document_page');
  Route::get('/admin/certificate/document/delete/{id}', "Admin\MrAdminCertificateController@DocumentDelete")->name('admin_document_delete');
  // Заявитель
  Route::get('/admin/certificate/applicant', "Admin\MrAdminCertificateController@ViewApplicant")->name('admin_applicant_page');
  Route::get('/admin/certificate/applicant/delete/{id}', "Admin\MrAdminCertificateController@ApplicantDelete")->name('admin_applicant_delete');
  // Продукция
  Route::get('/admin/certificate/product_info', "Admin\MrAdminCertificateController@ViewProductInfo")->name('admin_product_info_page');
  Route::get('/admin/certificate/product_info/delete/{id}', "Admin\MrAdminCertificateController@ProductInfoDelete")->name('admin_product_info_delete');


  // Загрузка из XML
  Route::match(['get', 'post'], '/admin/certificate/manufacturer/load/submit', "\App\Forms\Admin\MrCertificateManufacturerLoadForm@submitForm")->name('admin_manufacturer_load_submit');
  Route::match(['get', 'post'], '/admin/certificate/manufacturer/load/', "\App\Forms\Admin\MrCertificateManufacturerLoadForm@getFormBuilder")->name('admin_manufacturer_load_edit');


  #endregion

  //// Офисы
  Route::get('/admin/offices', "Admin\MrAdminOfficeController@List")->name('admin_offices');
  Route::get('/admin/office/{id}', "Admin\MrAdminOfficeController@OfficePage")->name('admin_office_page');
  Route::get('/admin/office/delete/{id}', "Admin\MrAdminOfficeController@officeDelete")->name('office_delete');
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
