<!DOCTYPE html>
<html>
<head>
    <title>Активация аккаунта</title>
</head>
<body>
    <h1>Активируйте ваш аккаунт</h1>

    <p>Мы создали ваш аккаунт, но требуется его активация.</p>
    <p>Для этого перейдите по ссылке ниже.</p>

    <p>Ваши данные для входа:</p>
    <p>Email: {{ $email }}</p>
    <p>Пароль: {{ $password }}</p>

    <p><a href="{{ URL::route('activateGet', ['code' => $code]) }}">Активировать аккаунт</a></p>
</body>
</html>