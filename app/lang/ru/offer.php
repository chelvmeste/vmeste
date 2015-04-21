<?php

return array(

    'response-success' => 'Вы успешно отправили запрос. Теперь вам доступна контактная информация',
    'help-request' => array(
        'title' => 'Заполнить заявку с просьбой о помощи',
        'date' => 'Дата',
        'time' => 'Время',
        'description' => 'Описание',
        'success' => 'Завяка успешно сохранена',
        'view' => 'Заявка о помощи',
        'response-button' => 'Откликнуться на просьбу',
        'response-button-login' => 'Необходимо войти на сайт чтобы откликнуться на просьбу',
        'response-button-application' => 'Чтобы откликнуться, нужно заполнить карточку добровольца',
        'already-has-response' => 'Вы уже откликались на эту заявку',
    ),
    'help-offer' => array(
        'title' => 'Заполнить карточку добровольца',
        'edit-title' => 'Редактировать карточку добровольца',
        'success' => 'Карточка успешно сохранена',
        'view' => 'Карточка добровольца',
        'response-button' => 'Обратиться',
        'response-button-login' => 'Необходимо войти на сайт чтобы обратиться за помошью',
        'response-button-application' => 'Нужно заполнить заявку о помощи',
        'already-has-response' => 'Вы уже обратились к этому человеку',
        'days' => 'Дни когда вы свободны',
    ),
    'help-requests' => array(
        'title' => 'Список заявок на оказание помощи',
        'empty' => 'Нет ни одной заявки, мы можете стать <a href=":link">первым</a>.',
        'edit-title' => 'Редактировать заявку о помощи',
    ),
    'help-offers' => array(
        'title' => 'Список добровольцев',
        'empty' => 'Нет ни одного добровольца, мы можете стать <a href=":link">первым</a>.',
    ),
    'help-offer-view' => array(
        'title' => 'Карточка добровольца',
        'days' => 'Дни когда свободен',
    ),
    'help-request-view' => array(
        'title' => 'Заявка о помощи',
    ),
    'response' => array(
        '1-want-help' => '<p>Вы хотели помочь <span class="name-on-map">:username</span>.</p><p>Адрес: <span class="adress">:address</span></p><p>Номер телефона: <span class="phone-on-map">:phone</span></p><p>:vk_id</p><p><a href=":requestLink">Посмотреть заявку</p>',
        '2-somebody-request-help' => '<p><span class="name-on-map">:username</span> <span class="can-help-text">обратился к Вам за помощью</span>.</p><p>Адрес: <span class="adress">:address</span></p><p>Номер телефона: <span class="phone-on-map">:phone</span></p><p>:vk_id</p><p><a href=":requestLink">Посмотреть заявку</a></p>',
        '3-you-request-help' => '<p>Вы обратилсь за помощью к <span class="name-on-map">:username</span>.</p><p>Адрес: <span class="adress">:address</span></p><p>Номер телефона: <span class="phone-on-map">:phone</span></p><p>:vk_id</p><p><a href=":requestLink">Посмотреть вашу заявку</a>.</p><p><a href=":offerLink">Посмотреть карточку :username</a></p>',
        '4-somebody-want-help' => '<p><span class="name-on-map">:username</span> хочет помочь вам с <a href=":requestLink">вашей зявкой</a>.</p><p>Адрес: <span class="adress">:address</span></p><p>Номер телефона: <span class="phone-on-map">:phone</span></p><p>:vk_id</p><p><a href=":offerLink">Посмотреть карточку добровольца :username</a></p>',
        'helped' => 'Помог!',
        'cancel' => 'Отменить',
        'response_text' => 'Оставьте сообщение',
        'not_empty_text' => 'Сообщение не может быть пустым',
        'not_found' => 'Не найдено',
        'no_access' => 'Нет доступа',
    ),
    'vk_link' => '<a target="_blank" href=":vk_id">Страница Вконтакте</a><br />',
    'edit' => 'Редактировать',
    'no-address' => 'Не указан',
    'no-phone' => 'Не указан',
    'no-vk' => 'Не указан',

);
