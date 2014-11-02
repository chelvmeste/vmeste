<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>{{isset($title) ? $title : '' }} - Проект "Вместе"</title>

        {{ Assets::css() }}

    </head>
    <body>
        @include('layouts.app.header')

        <div id="main-container">
            @yield('content')
        </div>

        @include('script-composer')
        {{ Assets::js() }}

    </body>
</html>
