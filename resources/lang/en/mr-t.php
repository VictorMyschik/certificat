<?php

use App\Models\MrTranslate;

$translate_arr = MrTranslate::GetWords('en');

return $translate_arr + [
    'Запомнить меня' => 'Remember Me',
    'Забыли пароль?' => 'Forgot You Password?',
    'Моя почта' => 'Email',
    'Пароль' => 'Password',
    'пароль' => 'password',
    'Вход' => 'Login',
    'Войти' => 'Login',
    'Логин' => 'Login',
    'Email' => 'E-Mail Address',
    'Повтор пароля' => 'Confirm Password',
    'Регистрация' => 'Register',
    'Часто задаваемые вопросы' => 'Frequently Asked Questions',
    'Ваши вопросы - наши ответы' => 'Your Questions - Our Answers',
    'Обратная связь' => 'Feedback',
    'Если остались вопросы, напишите нам' => 'If you have some questions write back',
    'Имя' => 'Name',
    'Сообщение' => 'Message',
    'Отправить' => 'Send',
    'ЧАВо' => 'FAQs',
    'Политика приватности' => 'Privacy Policy',
    'Политикой приватности' => 'Privacy Policy',
    'Я согласен с' => 'I agree with',
    'а также даю согласие на обработку персональных данных' => 'and consent to the processing of my personal data',
    'Эти данные отображаются на визитке' => 'It is public info',
    'Персональные данные' => 'Personal info',
    'Регистрационные' => 'Account data',
    'Личные' => 'Personal',
    'Дополнительные' => 'Additional',
    'версия' => 'version',
    'Фамилия' => 'Last Name',
    'Отчество' => 'Middle Name',
    'Должность' => 'Post',
    'Телефон' => 'Phone',
    'Сайт' => 'Site',
    'У Вас нет полномочий на это действие!' => 'Access violation!',
    'Разделы сайта' => 'Pages',
    'Веб сайт' => 'Web Site',
    'Нет данных' => 'No data',
    'Сохранить' => 'Save',
    'Сбросить' => 'Clear',
    'Пользователей' => 'Users',
    'Статистика' => 'Statistic',
    'Акаунт' => 'Account',
    'Кликов' => 'Clicks',
    'Примечание' => 'Description',
    'Изменить' => 'Edit',
    'Удалить' => 'Delete',
    'Новая' => 'New',
    'Покорение' => 'Conquest',
    'Серия и номер паспорта' => 'ID license',
    'Пол' => 'Gender',
    'Возраст' => 'Age',
    'Муж' => 'Male',
    'Жен' => 'Famale',
    'Город' => 'City',
    'Дата рождения' => 'Date of Birth',
    'Новая команда' => 'New command',
    'Выйти' => 'Logout',
    'выйти' => 'logout',
    'Удалить мой аккаунт' => 'Delete My Account',
    'Справочники' => 'References',
    'Поиск сертификата' => 'Certificate search'
  ];