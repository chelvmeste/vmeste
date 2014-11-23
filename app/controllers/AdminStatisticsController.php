<?php
use MrJuliuss\Syntara\Controllers\BaseController;

class AdminStatisticsController extends BaseController {

    public function getSiteVisits()
    {

        $dateStart = Input::get('dateStart', date('Y-m-d', time()-7*24*3600));
        $dateEnd = Input::get('dateEnd', date('Y-m-d'));

        $stats = StatisticsAggregation::aggregateCountByDateRange('siteVisit', $dateStart, $dateEnd);

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

        $dateStart = Input::get('dateStart', date('Y-m-d', time()-7*24*3600));
        $dateEnd = Input::get('dateEnd', date('Y-m-d'));

        $stats = StatisticsAggregation::aggregateCountByDateRange('pageView', $dateStart, $dateEnd);

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

        $dateStart = Input::get('dateStart'/*, date('Y-m-d', time()-7*24*3600)*/);
        $dateEnd = Input::get('dateEnd'/*, date('Y-m-d')*/);
        $initiator = Input::get('responseInitiator');

        if ($initiator && $initiator == 'offer')
        {
            $stats = StatisticsAggregation::aggregateCountByDateRange('createResponseFromOffer', $dateStart, $dateEnd);
        } else if ($initiator && $initiator == 'request')
        {
            $stats = StatisticsAggregation::aggregateCountByDateRange('createResponseFromRequest', $dateStart, $dateEnd);
        } else
        {
            $stats = StatisticsAggregation::aggregateCountByDateRange('createResponse', $dateStart, $dateEnd);
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