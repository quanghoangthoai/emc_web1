<?php

namespace Modules\Service\Widgets;

use Arrilot\Widgets\AbstractWidget;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class Revenue extends AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        $chart_options = [
            'chart_title' => 'Lượt xem',
            'report_type' => 'group_by_date',
            'model' => 'Modules\Order\Models\Service',
            'group_by_field' => 'name',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'totalhits',
            'chart_type' => 'line',
        ];

        $chart1 = new LaravelChart($chart_options);
        $name = 'CMS';
        return view('Service::widgets.chart', compact('name'));
    }


    /**
     * config
     */
    // public function config()
    // {
    //     return view('Dashboard::widgets.test_config')->render();
    // }
}
