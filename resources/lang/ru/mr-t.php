<?php


use App\Models\MrTranslate;

$translate_arr = MrTranslate::GetAllRusWords();

return $translate_arr + [
    'Админ'                                                                                        => 'Админ',
    'Доступ'                                                                                       => 'Доступ',
    'Имя'                                                                                          => 'Имя',
    'Страна'                                                                                       => 'Страна',
    'Ссылка'                                                                                       => 'Ссылка',
    'Электронная почта'                                                                            => 'Электронная почта',
    'Факс'                                                                                         => 'Факс',
    'Классификатор видов документов об оценке соответствия'                                        => 'Классификатор видов документов об оценке соответствия',
    'Классификатор единиц измерения'                                                               => 'Классификатор единиц измерения',
    'Условное обозначение'                                                                         => 'Условное обозначение',
    'Создать'                                                                                      => 'Создать',
    'Цифровой код'                                                                                 => 'Цифровой код',
    'Округление'                                                                                   => 'Округление',
    'Дата с'                                                                                       => 'Дата с',
    'Дата по'                                                                                      => 'Дата по',
    'Код'                                                                                          => 'Код',
    'Континент'                                                                                    => 'Континент',
    'Наименование'                                                                                 => 'Наименование',
    'Моя почта'                                                                                    => 'Моя почта',
    'Пароль'                                                                                       => 'Пароль',
    'пароль'                                                                                       => 'пароль',
    'Запомнить меня'                                                                               => 'Запомнить меня',
    'Забыли пароль?'                                                                               => 'Забыли пароль?',
    'Вход'                                                                                         => 'Login',
    'Войти'                                                                                        => 'Войти',
    'Логин'                                                                                        => 'Логин',
    'Email'                                                                                        => 'Email',
    'Повтор пароля'                                                                                => 'Повтор пароля',
    'Регистрация'                                                                                  => 'Регистрация',
    'Часто задаваемые вопросы'                                                                     => 'Часто задаваемые вопросы',
    'Ваши вопросы - наши ответы'                                                                   => 'Ваши вопросы - наши ответы',
    'Обратная связь'                                                                               => 'Обратная связь',
    'Если остались вопросы, напишите нам'                                                          => 'Если остались вопросы, напишите нам',
    'Имя'                                                                                          => 'Имя',
    'Сообщение'                                                                                    => 'Сообщение',
    'Отправить'                                                                                    => 'Отправить',
    'ЧАВо'                                                                                         => 'ЧАВо',
    'Политика приватности'                                                                         => 'Политика приватности',
    'Политикой приватности'                                                                        => 'Политикой приватности',
    'Я согласен с'                                                                                 => 'Я согласен с',
    'а также даю согласие на обработку персональных данных'                                        => 'а также даю согласие на обработку персональных данных',
    'Эти данные отображаются на визитке'                                                           => 'Эти данные отображаются на визитке',
    'Персональные данные'                                                                          => 'Персональные данные',
    'Регистрационные'                                                                              => 'Регистрационные',
    'Визитки'                                                                                      => 'Визитки',
    'Личные'                                                                                       => 'Личные',
    'Дополнительные'                                                                               => 'Дополнительные',
    'версия'                                                                                       => 'версия',
    'Фамилия'                                                                                      => 'Фамилия',
    'Отчество'                                                                                     => 'Отчество',
    'Должность'                                                                                    => 'Должность',
    'Телефон'                                                                                      => 'Телефон',
    'Сайт'                                                                                         => 'Сайт',
    'У Вас нет полномочий на это действие!'                                                        => 'У Вас нет полномочий на это действие!',
    'Разделы сайта'                                                                                => 'Разделы сайта',
    'Веб сайт'                                                                                     => 'Веб сайт',
    'Нет данных'                                                                                   => 'Нет данных',
    'Сохранить'                                                                                    => 'Сохранить',
    'Отменить'                                                                                     => 'Отменить',
    'Сбросить'                                                                                     => 'Сбросить',
    'Пользователей'                                                                                => 'Пользователей',
    'Статистика'                                                                                   => 'Статистика',
    'Акаунт'                                                                                       => 'Акаунт',
    'Кликов'                                                                                       => 'Кликов',
    'Примечание'                                                                                   => 'Примечание',
    'Изменить'                                                                                     => 'Изменить',
    'Удалить'                                                                                      => 'Удалить',
    'Новая'                                                                                        => 'Новая',
    'Покорение'                                                                                    => 'Покорение',
    'Серия и номер паспорта'                                                                       => 'Серия и номер паспорта',
    'Пол'                                                                                          => 'Пол',
    'Возраст'                                                                                      => 'Возраст',
    'Муж'                                                                                          => 'Муж',
    'Жен'                                                                                          => 'Жен',
    'Город'                                                                                        => 'Город',
    'Дата рождения'                                                                                => 'Дата рождения',
    'Новая команда'                                                                                => 'Новая команда',
    'Выйти'                                                                                        => 'Выйти',
    'выйти'                                                                                        => 'выйти',
    'Удалить мой аккаунт'                                                                          => 'Удалить мой аккаунт',
    'Справочники'                                                                                  => 'Справочники',
    'Поиск сертификата'                                                                            => 'Поиск сертификата',
    'Страны мира'                                                                                  => 'Страны мира',
    'Настройки'                                                                                    => 'Настройки',
    'Персональные'                                                                                 => 'Персональные',
    'Администратор'                                                                                => 'Администратор',
    'Скидка'                                                                                       => 'Скидка',
    'Тарифные планы'                                                                               => 'Тарифные планы',
    'Услуги'                                                                                       => 'Услуги',
    'Мониторинг'                                                                                   => 'Мониторинг',
    'Пользователи'                                                                                 => 'Пользователи',
    'Пользователь'                                                                                 => 'Пользователь',
    'Финансы'                                                                                      => 'Финансы',
    'Виртуальный офис'                                                                             => 'Виртуальный офис',
    'Дата регистрации'                                                                             => 'Дата регистрации',
    'Текущий сеанс'                                                                                => 'Текущий сеанс',
    'Глобальные скидки'                                                                            => 'Глобальные скидки',
    'Скидки'                                                                                       => 'Скидки',
    'Баланс'                                                                                       => 'Баланс',
    'Добавить'                                                                                     => 'Добавить',
    'Мой офис'                                                                                     => 'Мой офис',
    'На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.'               => 'На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.',
    'Проверьте свою электронною почты'                                                             => 'Проверьте свою электронною почту',
    'Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.' => 'Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.',
    'Если вы не получили письмо'                                                                   => 'Если вы не получили письмо',
    'нажмите здесь, чтобы отправить ещё раз'                                                       => 'нажмите здесь, чтобы отправить ещё раз',
    'Все поля обязательны для заполнения'                                                          => 'Все поля обязательны для заполнения',
    'Нет прав доступа'                                                                             => 'Нет прав доступа',
    'Новый пользователь в системе'                                                                 => 'Новый пользователь в системе',
    'Предоставление доступа к системе'                                                             => 'Предоставление доступа к системе',
    'Нарушение доступа'                                                                            => 'Нарушение доступа',
    'Добавить нового пользователя'                                                                 => 'Добавить нового пользователя',
    'Личные настройки'                                                                             => 'Личные настройки',
    'Привилегии'                                                                                   => 'Привилегии',
    'Отменить подписку'                                                                            => 'Отменить подписку',
    'Подписаться на новости'                                                                       => 'Подписаться на новости',
    'Удалить акаунт'                                                                               => 'Удалить акаунт',
    'Офис создан'                                                                                  => 'Офис создан',
    'Тарифы'                                                                                       => 'Тарифы',
    'Новый'                                                                                        => 'Новый',
    'Пользователь не найден'                                                                       => 'Пользователь не найден',
    'Только администры могут менять статус'                                                        => 'Только администры могут менять статус',
    'Доступ запрещён'                                                                              => 'Доступ запрещён',
    'Создать офис'                                                                                 => 'Создать офис',
    'Переименовать офис'                                                                           => 'Переименовать офис',
    'Личная страница'                                                                              => 'Личная страница',
    'Справочник не найден'                                                                         => 'Справочник не найден',
    'Изменить параметры входа'                                                                     => 'Изменить параметры входа',
    'Telegram оповещение'                                                                          => 'Telegram оповещение',
    'Офисы'                                                                                        => 'Офисы',
    'обязательно'                                                                                  => 'обязательно',
    'Неправильный формат сообщения'                                                                => 'Message format are wrong',
    'Не найдены данные'                                                                            => 'Не найдены данные',
    'Валюты мира'                                                                                  => 'Валюты мира',
  ];