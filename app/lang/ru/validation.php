<?php

return array(
    'custom' => array(
        'email' => array(
            'required' => 'Укажите адрес вашей электронной почты',
            'email' => 'Неверный формат электронной почты',
            'unique' => 'Данная электронная почту уже используется',
        ),
        'password' => array(
            'required' => 'Укажите ваш пароль',
            'min' => 'Пароль должен быть не менее :min символов',
            'max' => 'Пароль должен быть не более :max символов',
        ),
        'first_name' => array(
            'required' => 'Укажите ваше имя',
            'min' => 'Имя должно быть не менее :min символов',
            'max' => 'Имя должно быть не более :max символов',
            'alpha_dash' => 'Имя содержит недопустимые символы',
        ),
        'last_name' => array(
            'required' => 'Укажите вашу фамилию',
            'min' => 'Фамилия должна быть не менее :min символов',
            'max' => 'Фамилия должна быть не более :max символов',
            'alpha_dash' => 'Фамилия содержит недопустимые символы',
        ),
        'gender' => array(
            'in' => 'Недопустимый пол',
        ),
        'phone' => array(
            'digits_between' => 'Телефон должен содержать только цифры и быть от 7 до 16 символов длиной',
        ),
        'vk_id' => array(
            'alpha_dash' => 'Недопустимые символы для VK идентификатора',
        ),
        'birthdate' => array(
            'date_format' => 'Неверный формат даты рождения',
            'day' => array(
                'required' => 'Укажите день вашего рождения',
                'date_format' => 'Неверный формат дня рождения',
            ),
            'month' => array(
                'required' => 'Укажите месяц вашего рождения',
                'date_format' => 'Неверный формат месяца рождения',
            ),
            'year' => array(
                'required' => 'Укажите год вашего рождения',
                'date_format' => 'Неверный формат года рождения',
            ),
        ),
        'description' => array(
            'required' => 'Укажите описание',
            'min' => 'Слишком короткое описание',
        ),
        'time' => array(
            'required' => 'Укажите время',
            'date_format' => 'Неверный формат времени',
            'minutes' => array(
                'required' => 'Укажите время',
                'date_format' => 'Неверный формат времени',
            ),
            'hours' => array(
                'required' => 'Укажите время',
                'date_format' => 'Неверный формат времени',
            ),
        ),
        'date' => array(
            'required' => 'Укажите дату',
            'date_format' => 'Неверный формат даты',
            'day' => array(
                'required' => 'Укажите день',
                'date_format' => 'Неверный формат дня',
            ),
            'month' => array(
                'required' => 'Укажите месяц',
                'date_format' => 'Неверный формат месяца',
            ),
            'year' => array(
                'required' => 'Укажите год',
                'date_format' => 'Неверный формат года',
            ),
        ),
        'days' => array(
            '1' => array(
                'time_start' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время начала для понедельника',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время начала для понедельника',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_id' => 'Укажите время начала для понедельника',
                ),
                'time_end' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время окончания для понедельника',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время окончания для понедельника',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время окончания для понедельника',
                ),
            ),
            '2' => array(
                'time_start' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время начала для вторника',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время начала для вторника',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время начала для вторника',
                ),
                'time_end' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время окончания для вторника',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время окончания для вторника',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время окончания для вторника',
                ),
            ),
            '3' => array(
                'time_start' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время начала для среды',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время начала для среды',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время начала для среды',
                ),
                'time_end' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время окончания для среды',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время окончания для среды',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время окончания для среды',
                ),
            ),
            '4' => array(
                'time_start' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время начала для четверга',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время начала для четверга',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время начала для четверга',
                ),
                'time_end' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время окончания для четверга',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время окончания для четверга',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время окончания для четверга',
                ),
            ),
            '5' => array(
                'time_start' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время начала для пятницы',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время начала для пятницы',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время начала для пятницы',
                ),
                'time_end' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время окончания для пятницы',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время окончания для пятницы',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время окончания для пятницы',
                ),
            ),
            '6' => array(
                'time_start' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время начала для субботы',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время начала для субботы',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время начала для субботы',
                ),
                'time_end' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время окончания для субботы',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время окончания для субботы',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время окончания для субботы',
                ),
            ),
            '7' => array(
                'time_start' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время начала для воскресенья',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время начала для воскресенья',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время начала для воскресенья',
                ),
                'time_end' => array(
                    'hours' => array(
                        'required_if' => 'Укажите время окончания для воскресенья',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'minutes' => array(
                        'required_if' => 'Укажите время окончания для воскресенья',
                        'date_format' => 'Неверный формат времени'
                    ),
                    'required_if' => 'Укажите время окончания для воскресенья',
                ),
            ),
        ),
        'response_text' => array(
            'required' => 'Заполните ваш ответ',
            'min' => 'Слишком короткий ответ'
        ),
        'response_type' => array(
            'required' => 'Укажите результат',
            'in' => 'Неверный тип результата'
        ),
        'day' => array(
            'in' => 'Неверный день'
        ),
    ),
);





















