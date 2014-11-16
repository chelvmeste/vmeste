@if (Sentry::check())
    @if($currentUser->hasAccess(Config::get('syntara::permissions.viewStatistic')))
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-list-alt"></i> <span>{{ trans('admin.navigation.statistics.index') }}</span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ URL::route('getSiteVisits') }}">{{ trans('admin.navigation.statistics.site-visit') }}</a></li>
            <li><a href="{{ URL::route('getPageViews') }}">{{ trans('admin.navigation.statistics.page-view') }}</a></li>
            <li><a href="{{ URL::route('getCreateResponse') }}">{{ trans('admin.navigation.statistics.create-response') }}</a></li>
        </ul>
    </li>
    @endif
@endif