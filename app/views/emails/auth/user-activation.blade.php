<!DOCTYPE html>
<html>
<head>
    <title>Account activation</title>
</head>
<body>
    <h1>Activate your account</h1>

    <p>We confirm your account creation, but it must be activated before being used.</p>
    <p>Click the link below to activate your account.</p>

    <p>You credentials to enter:</p>
    <p>Email: {{ $email }}</p>
    <p>Password: {{ $password }}</p>

    <p><a href="{{ URL::route('activateGet', ['code' => $code]) }}">Activate your account</a></p>
</body>
</html>