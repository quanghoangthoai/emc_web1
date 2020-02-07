<?php

namespace Modules\Order\Widgets;

use ConsoleTVs\Charts\Facades\Charts;
use Modules\Request\Models\Requests;
use Modules\Order\Models\Order;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class Revenue extends AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        // $order = Requests::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"), date('Y'))
        //     // ->jorn('request', 'request.request_id', '=', 'order.request_id')
        //     ->get();

        // $data['charts'] = Charts::database($order, 'bar', 'highcharts')

        //     ->title("thống kê")

        //     ->elementLabel("payment")

        //     ->dimensions(1000, 500)

        //     ->responsive(false)

        //     ->groupByMonth(date('Y'), true);

        $data['name'] = 'CMS';
        return view('Order::widgets.revenue', $data);
    }

    /**
     * config
     */
    // public function config()
    // {
    //     return view('Dashboard::widgets.test_config')->render();
    // }
}
