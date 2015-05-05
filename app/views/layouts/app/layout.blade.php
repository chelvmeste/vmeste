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



        <div id="main">
            @include('layouts.app.header')
            <div class="content">
                <div class="all">
                    @yield('content')
                </div>
            </div>
            @include('layouts.app.footer')
        </div>

        {{--{{ Blind::getBlindSwitcher() }}--}}

        @include('script-composer')
        {{ Assets::js() }}

    </body>
</html>
