<header class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="logo">
                <a href="{{ URL::route('homeGet') }}"><img src="{{ asset('assets/img/logo-min.png') }}" width="62" alt=""></a>
                <div class="description">
                    <span>«Вместе»</span>
                    Все, что мы делаем, делаем вместе
                </div>
            </div>
        </div>
        <div class="col-lg-4 usermenu">
            @if (Sentry::check())
                <a href="{{ URL::route('profileGet', ['id' => Sentry::getUser()->getId()]) }}">{{ !empty(Sentry::getUser()->username) ? Sentry::getUser()->username : Sentry::getUser()->email }}</a>
                <span> | </span>
                @if(Sentry::getUser()->isSuperUser())
                    <a href="{{ URL::route('indexDashboard') }}">{{ trans('global.header.admin') }}</a>
                    <span> | </span>
                @endif
                <a href="{{ URL::route('logoutGet') }}">{{ trans('global.header.logout') }}</a>
            @else
                <a href="{{ URL::route('loginGet') }}">{{ trans('global.header.login') }}</a>
            @endif
        </div>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="nav navbar-nav">
                    <li{{ Route::currentRouteName() == 'homeGet' ? ' class="active"' : '' }}><a href="{{ URL::route('homeGet') }}">{{ trans('global.header.index') }}</a></li>
                    @if (Sentry::check())
                        <li{{ Route::currentRouteName() == 'profileGet' ? ' class="active"' : '' }}><a href="{{ URL::route('profileGet', ['id' => Sentry::getUser()->getId()]) }}">{{ trans('global.header.profile') }}</a></li>
                    @endif
                    <li{{ Route::currentRouteName() == 'helpRequestNewGet' ? ' class="active"' : '' }}><a href="{{ URL::route('helpRequestNewGet') }}">{{ trans('global.header.help-request') }}</a></li>
                    <li{{ Route::currentRouteName() == 'helpOfferNewGet' ? ' class="active"' : '' }}><a href="{{ URL::route('helpOfferNewGet') }}">{{ trans('global.header.help-offer') }}</a></li>
                    <li{{ Route::currentRouteName() == 'helpRequestsGet' ? ' class="active"' : '' }}><a href="{{ URL::route('helpRequestsGet') }}">{{ trans('global.header.help-requests') }}</a></li>
                    {{--<li{{ Route::currentRouteName() == 'helpOffersGet' ? ' class="active"' : '' }}><a href="{{ URL::route('helpOffersGet') }}">{{ trans('global.header.help-offers') }}</a></li>--}}
                </ul>
            </div>
        </div>
    </nav>
</header>

