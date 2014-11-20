@if (Sentry::check())
    @if($currentUser->hasAccess(Config::get('syntara::permissions.statistics-management')))
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-list-alt"></i> <span>{{ trans('admin.navigation.statistics.index') }}</span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ URL::route('getSiteVisits') }}">{{ trans('admin.navigation.statistics.site-visit') }}</a></li>
            <li><a href="{{ URL::route('getPageViews') }}">{{ trans('admin.navigation.statistics.page-view') }}</a></li>
            <li><a href="{{ URL::route('getCreateResponse') }}">{{ trans('admin.navigation.statistics.create-response') }}</a></li>
        </ul>
    </li>
    @endif
    @if($currentUser->hasAccess(Config::get('syntara::permissions.offers-management')) || $currentUser->hasAccess(Config::get('syntara::permissions.responses-management')))
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-file"></i> <span>{{ trans('admin.navigation.offers.index') }}</span></a>
        <ul class="dropdown-menu">
            @if($currentUser->hasAccess(Config::get('syntara::permissions.offers-management')))
                <li><a href="{{ URL::route('getAdminOffers') }}">{{ trans('admin.navigation.offers.offers') }}</a></li>
                <li><a href="{{ URL::route('getAdminRequests') }}">{{ trans('admin.navigation.offers.requests') }}</a></li>
            @endif
            @if($currentUser->hasAccess(Config::get('syntara::permissions.responses-management')))
                <li><a href="{{ URL::route('getAdminResponses') }}">{{ trans('admin.navigation.offers.responses') }}</a></li>
            @endif
        </ul>
    </li>
    @endif
@endif