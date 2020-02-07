<?php

namespace Modules\Service\Controllers;

use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Classes\C3\Chart;

use Modules\Service\Models\Service;
use App\Charts\orderChart;
use Illuminate\Http\Request;
use System\Core\Controllers\AdminController as SystemAdminController;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class Widgetcontroller extends SystemAdminController
{
    public function index()
    {

        $chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);
        return view('Service::widgets.chart1', compact('chart1'));
    }
}
