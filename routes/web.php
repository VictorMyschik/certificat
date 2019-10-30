<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Auth::routes();

Route::get('locale/{locale}', function ($locale) {
  Session::put('locale', $locale);
  return redirect()->back();
});

Route::get('/', 'HomeController@index')->name('welcome');
Route::match(['get', 'post'], '/faq', 'MrFAQController@index');

Route::get('/policy', 'MrPolicyController@View');

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
Route::post('/search', 'HomeController@Search')->name('search');

// Страница инфо о сертификате
Route::get('/certificate/{number}', 'MrCertificateController@View');


//// для авторизованных
Route::group(['middleware' => 'auth'], function () {

  //// Кабинет пользователя
  Route::get('/panel', "User\MrUserController@View")->name('panel');
  // Изменение личных данных пользователя
  Route::POST('/panel/edit/{id}', "User\MrUserController@Edit")->name('panel_edit');
  Route::get('/panel/races', "User\MrUserController@Races")->name('panel_races');

  Route::match(['get', 'post'], '/admin/language/word/edit/{id}/submit', "Forms\MrTranslateWordEditForm@submitForm");
  Route::match(['get', 'post'], '/admin/language/word/edit/{id}', "Forms\MrTranslateWordEditForm@builderForm")->name('translate_word_edit');

  //// Удаление аккаунта
  Route::match(['get', 'post'], '/panel/delete/', "Forms\MrUserDeleteForm@builderForm")->name('user_delete');
  Route::match(['get', 'post'], '/panel/delete/submit', "Forms\MrUserDeleteForm@submitForm");

});


//// для Админа
Route::group(['middleware' => 'is_admin'], function () {

  Route::get('/test', "MrTestController@index");
  //// Админка
  Route::get('/admin', "Admin\MrAdminController@index")->name('admin');
  // FAQ
  Route::match(['get', 'post'], '/admin/faq', "Admin\MrAdminFaqController@list")->name('faq');
  Route::match(['get', 'post'], '/admin/faq/edit/{id}', "Admin\MrAdminFaqController@edit")->name('edit_faq');
  Route::get('/admin/faq/delete/{id}', "Admin\MrAdminFaqController@delete")->name('delete_faq');
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
  Route::get('/admin/users/delete/{id}',"Admin\MrAdminController@userDeleteForever")->name('user_delete_forever');
  Route::match(['get', 'post'], '/admin/users/edit/{id}/submit', "Forms\Admin\MrUserEditForm@submitForm");
  Route::match(['get', 'post'], '/admin/users/edit/{id}', "Forms\Admin\MrUserEditForm@builderForm")->name('user_edit');

  // Офисы
  Route::get('/admin/offeces',"Admin\MrAdminOfficeController@List")->name('offices');
  // Тарифы
  Route::get('/admin/tariffs',"Admin\MrAdminTariffController@List")->name('tariffs');

  Route::match(['get', 'post'], '/admin/tariff/edit/{id}/submit', "Forms\Admin\MrAdminTariffEditForm@submitForm");
  Route::match(['get', 'post'], '/admin/tariff/edit/{id}', "Forms\Admin\MrAdminTariffEditForm@builderForm")->name('tariff_edit');


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
  //// Перевод сайта на другие языки
  Route::get('/admin/language', "Admin\MrAdminLanguageController@List")->name('language_list');
  // Добавить новый язык
  Route::get('/admin/language/add', "Admin\MrAdminLanguageController@Add")->name('language_add');
  // Форма редактирования языка
  Route::match(['get', 'post'], '/admin/language/edit/{id}/submit', "Forms\Admin\MrLanguageEditForm@submitForm");
  Route::match(['get', 'post'], '/admin/language/edit/{id}', "Forms\Admin\MrLanguageEditForm@builderForm")->name('admin_language_edit_form');
  // Удалить перевод слов(а)
  Route::get('/admin/language/word/{id}/delete', "Admin\MrAdminLanguageController@translatedWordDelete")->name('translate_word_delete');
  // Форма редактирования перевода
  Route::match(['get', 'post'], '/admin/language/word/edit/{id}/submit', "Forms\Admin\MrTranslateWordEditForm@submitForm");
  Route::match(['get', 'post'], '/admin/language/word/edit/{id}', "Forms\Admin\MrTranslateWordEditForm@builderForm")->name('translate_word_edit');
  // Политика конфиденциальности
  Route::get('/admin/policy', "Admin\MrAdminPolicyController@List")->name('admin_policy_list');
  Route::match(['get', 'post'], '/admin/policy/edit/{id}', "Admin\MrAdminPolicyController@edit")->name('edit_policy');
  Route::get('/admin/policy/delete/{id}', "Admin\MrAdminPolicyController@delete")->name('delete_policy');
  //// Справочники
  // Удаление строки
  Route::get('/admin/reference/{name}/delete/{id}', "Admin\MrAdminReferences@DeleteForID");
  // Страны мира
  Route::get('/admin/reference/{name}', "Admin\MrAdminReferences@View");
  // Переустановка справочника
  Route::get('/admin/reference/country/rebuild', "Admin\MrAdminReferences@RebuildCountry");
  // Форма редактирования справочника стран
  Route::match(['get', 'post'], '/admin/reference/country/edit/{id}/submit', "Forms\Admin\MrReferenceCountryEditForm@submitForm");
  Route::match(['get', 'post'], '/admin/reference/country/edit/{id}', "Forms\Admin\MrReferenceCountryEditForm@builderForm")->name('admin_reference_country_edit_form');

  //// Проект СЕРТИФИКАТЫ СООТВЕТСТВИЯ
  Route::get('/admin/certificate', "Admin\MrAdminCertificateController@View");
  Route::get('/admin/certificate/details/{id}', "Admin\MrAdminCertificateController@CertificateDetails");
  // Форма редактированиея сведения о сертификате
  Route::match(['get', 'post'], '/admin/certificate/{certificate_id}/details/edit/{id}/submit', "Forms\Admin\MrCertificateDetailsEditForm@submitForm");
  Route::match(['get', 'post'], '/admin/certificate/{certificate_id}/details/edit/{id}', "Forms\Admin\MrCertificateDetailsEditForm@builderForm")->name('admin_certificate_details_edit_form');
  // Форма добавления нового сертификата
  Route::match(['get', 'post'], '/admin/certificate/edit/{id}/submit', "Forms\Admin\MrCertificateEditForm@submitForm");
  Route::match(['get', 'post'], '/admin/certificate/edit/{id}', "Forms\Admin\MrCertificateEditForm@builderForm")->name('admin_certificate_edit_form');
  // Удалить сертификат
  Route::get('/admin/certificate/delete/{id}', "Admin\MrAdminCertificateController@certificateDelete");
  Route::get('/admin/certificate/{certificate_id}/details/delete/{id}', "Admin\MrAdminCertificateController@certificateDetailsDelete");
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
