<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Восстановление пароля</h2>

		<div>
			Чтобы восстановить пароль перейдите по этой <a href="{{ URL::route('resetGet', array($token)) }}">ссылке</a>.<br/>
			Срок действия ссылки истекает через {{ Config::get('auth.reminder.expire', 60) }} минут.
		</div>
	</body>
</html>
