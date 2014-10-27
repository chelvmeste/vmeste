<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::route('homeGet') }}">{{ trans('global.header.title') }}</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ URL::route('helpRequestGet') }}">{{ trans('global.header.help-request') }}</a></li>
                <li><a href="{{ URL::route('helpOfferGet') }}">{{ trans('global.header.help-offer') }}</a></li>
                <li><a href="{{ URL::route('helpRequestsGet') }}">{{ trans('global.header.help-requests') }}</a></li>
                <li><a href="{{ URL::route('helpOffersGet') }}">{{ trans('global.header.help-offers') }}</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Sentry::check())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ !empty(Sentry::getUser()->username) ? Sentry::getUser()->username : Sentry::getUser()->email }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ URL::route('profileGet', ['id' => Sentry::getUser()->getId()]) }}">{{ trans('global.header.profile') }}</a></li>
                        @if(Sentry::getUser()->isSuperUser())
                            <li><a href="{{ URL::route('indexDashboard') }}">{{ trans('global.header.admin') }}</a></li>
                        @endif
                        <li class="divider"></li>
                        <li><a href="{{ URL::route('logoutGet') }}">{{ trans('global.header.logout') }}</a></li>
                    </ul>
                </li>
                @else
                    <li><a href="{{ URL::route('loginGet') }}">{{ trans('global.header.login') }}</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>