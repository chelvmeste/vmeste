<?php

Form::macro('selectDays', function($name, $selected = null, $options = array(), $format = 'd')
{
    $days = array(null => trans('global.day'));

    foreach (range(1, 31) as $day)
    {
        $days[$day] = $day;
    }

    return Form::select($name, $days, $selected, $options);
});
Form::macro('selectMonths', function($name, $selected = null, $options = array(), $format = 'F')
{
    $months = array(null => trans('global.month'));

    foreach (range(1, 12) as $month)
    {
        $months[$month] = Date::parse(mktime(0, 0, 0, $month, 1))->format($format);
    }

    return Form::select($name, $months, $selected, $options);
});
Form::macro('selectYears', function($name, $start = null, $selected = null, $options = array())
{
    $years = array(null => trans('global.year'));
    $start = $start ? $start : date('Y');

    foreach (range($start, date('Y')+1) as $year)
    {
        $years[$year] = $year;
    }

    return Form::select($name, $years, $selected, $options);
});
