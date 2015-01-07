<?php
use MrJuliuss\Syntara\Controllers\BaseController;

class AdminStatisticsController extends BaseController {

    public function getSiteVisits()
    {

        $dateStart = Input::get('dateStart', date('Y-m-d', time()-30*24*3600));
        $dateEnd = Input::get('dateEnd', date('Y-m-d', time()+1*24*3600));

        $stats = Tracker::sessionsForPeriod($dateStart, $dateEnd, true);

        $datas = array(
            'stats' => $stats,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
        );

        if(Request::ajax())
        {
            $html = View::make('admin.stats.stats-partial', array('datas' => $datas))->render();

            return Response::json(array('html' => $html));
        }

        $this->layout = View::make('admin.stats.site-visits', array('datas' => $datas));
        $this->layout->title = trans('admin.navigation.statistics.site-visits');
        $this->layout->breadcrumb = array(
            array(
                'title' => trans('admin.navigation.statistics.site-visit'),
                'link' => URL::route('getSiteVisits'),
                'icon' => 'glyphicon-file'
            ),
        );

    }

    public function getPageViews()
    {

        $dateStart = Input::get('dateStart', date('Y-m-d', time()-31*24*3600));
        $dateEnd = Input::get('dateEnd', date('Y-m-d', time()+1*24*3600));

        $stats = Tracker::pageViewsForPeriod($dateStart, $dateEnd, true);

        $datas = array(
            'stats' => $stats,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
        );

        if (Request::ajax())
        {
            $html = View::make('admin.stats.stats-partial', array('datas' => $datas))->render();

            return Response::json(array('html' => $html));
        }

        $this->layout = View::make('admin.stats.page-views', array('datas' => $datas));
        $this->layout->title = trans('admin.navigation.statistics.page-view');
        $this->layout->breadcrumb = array(
            array(
                'title' => trans('admin.navigation.statistics.page-view'),
                'link' => URL::route('getSiteVisits'),
                'icon' => 'glyphicon-file'
            ),
        );

    }

    public function getCreateResponse()
    {

        $dateStart = Input::get('dateStart', date('Y-m-d', time()-31*24*3600));
        $dateEnd = Input::get('dateEnd', date('Y-m-d', time()+1*24*3600));
        $initiator = Input::get('responseInitiator');

        if ($initiator && $initiator == 'offer')
        {
            $stats = Tracker::customEventForPeriod('vmeste.createResponseFromOffer', $dateStart, $dateEnd, true);
        } else if ($initiator && $initiator == 'request')
        {
            $stats = Tracker::customEventForPeriod('vmeste.createResponseFromRequest', $dateStart, $dateEnd, true);
        } else
        {
            $stats = Tracker::customEventForPeriod('vmeste.createResponse', $dateStart, $dateEnd, true);
        }

        $datas = array(
            'stats' => $stats,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
        );

        if(Request::ajax())
        {
            $html = View::make('admin.stats.stats-partial', array('datas' => $datas))->render();

            return Response::json(array('html' => $html));
        }

        $this->layout = View::make('admin.stats.create-response', array('datas' => $datas));
        $this->layout->title = trans('admin.navigation.statistics.create-response');
        $this->layout->breadcrumb = array(
            array(
                'title' => trans('admin.navigation.statistics.create-response'),
                'link' => URL::route('getCreateResponse'),
                'icon' => 'glyphicon-file'
            ),
        );

    }

}
