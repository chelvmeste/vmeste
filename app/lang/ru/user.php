<?php

return array(
    'register' => array(
        'title' => 'Регистрация',
        'email' => 'E-mail адрес',
        'username' => 'Логин',
        'password' => 'Пароль',
        'password_confirm' => 'Пароль еще раз',
        'first_name' => 'Имя',
        'last_name' => 'Фамилия',
        'submit' => 'Зарегистрироваться',
        'success_title' => 'Регистрация завершена',
        'success' => 'Регистрация почти завершена. На e-mail отправлено письмо со ссылкой активации.',
    ),
    'login' => array(
        'title' => 'Вход',
        'email' => 'E-mail адрес',
        'password' => 'Пароль',
        'enter' => 'Войти',
        'register' => 'Зарегистрироваться',
        'remind_password' => 'Восстановить пароль',
        'remember' => 'Запомнить меня',
    ),
    'activate' => array(
        'title' => 'Активация аккаунта',
        'success' => 'Ваш аккаунт успешно активирован. Теперь вы можете <a href="'.URL::route('loginGet').'">войти</a>.',
        'failed' => 'Ошибка при активации аккаунта. Аккаунт не найден либо уже активирован.',
    ),
    'remind' => array(
        'title' => 'Восстановление пароля',
        'email' => 'E-mail адрес',
        'submit' => 'Восстановить',
    ),
    'reset' => array(
        'title' => 'Сброс пароля',
        'email' => 'E-mail адрес',
        'password' => 'Пароль',
        'password_confirmation' => 'Пароль еще раз',
        'submit' => 'Сохранить',
    ),
    'edit-profile' => array(
        'title' => 'Редактировать профиль',
        'email' => 'E-mail адрес',
        'username' => 'Логин',
        'password' => 'Пароль',
        'password_confirm' => 'Пароль еще раз',
        'first_name' => 'Имя',
        'last_name' => 'Фамилия',
        'submit' => 'Сохранить',
        'success' => 'Профиль успешно обновлен',
    ),
);