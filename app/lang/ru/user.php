<?php

return array(
    'email' => 'E-mail адрес',
    'username' => 'Логин',
    'password' => 'Пароль',
    'first_name' => 'Имя',
    'last_name' => 'Фамилия',
    'password_confirm' => 'Пароль еще раз',
    'gender' => 'Пол',
    'vk_id' => 'Вконтакте',
    'vk_id_prepopulate' => 'vk.com /',
    'phone' => 'Номер телефона',
    'phone_prepopulate' => '+',
    'birthdate' => 'Дата рождения',
    'address' => 'Адрес',
    'register' => array(
        'title' => 'Регистрация',
        'submit' => 'Зарегистрироваться',
        'success_title' => 'Регистрация завершена',
        'success' => 'Регистрация почти завершена. На e-mail отправлено письмо со ссылкой активации.',
    ),
    'login' => array(
        'title' => 'Вход',
        'enter' => 'Войти',
        'register' => 'Зарегистрироваться',
        'remind_password' => 'Восстановить пароль',
        'remember' => 'Запомнить меня',
        'invalid_password' => 'Неверный пароль',
        'not_activated' => 'Пользователь не активирован',
    ),
    'activate' => array(
        'title' => 'Активация аккаунта',
        'success' => 'Ваш аккаунт успешно активирован. Теперь вы можете <a href="'.URL::route('loginGet').'">войти</a>.',
        'failed' => 'Ошибка при активации аккаунта. Аккаунт не найден либо уже активирован.',
    ),
    'remind' => array(
        'title' => 'Восстановление пароля',
        'submit' => 'Восстановить',
    ),
    'reset' => array(
        'title' => 'Сброс пароля',
        'submit' => 'Сохранить',
    ),
    'edit-profile' => array(
        'title' => 'Редактировать профиль',
        'submit' => 'Сохранить',
        'success' => 'Профиль успешно обновлен',
    ),
    'profile' => array(
        'title' => 'Профиль пользователя :name',
    ),
);
