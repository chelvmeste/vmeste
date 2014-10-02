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
                <li class="active"><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                {{--<li><a href="#">Link</a></li>--}}
                @if (Sentry::check())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Sentry::getUser()->username }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ URL::route('logoutGet') }}">{{ trans('global.header.logout') }}</a></li>
                    </ul>
                </li>
                @else
                    <li><a href="{{ URL::route('loginGet') }}">{{ trans('global.header.login') }}</a></li>
                    <li><a href="{{ URL::route('registerGet') }}">{{ trans('global.header.register') }}</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>