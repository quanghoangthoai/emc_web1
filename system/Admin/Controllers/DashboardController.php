<?php

namespace System\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Analytics;
use Carbon\Carbon;
use Spatie\Analytics\Period;
use System\Admin\Models\AdminWidget;
use System\Core\Controllers\AdminController;

class DashboardController extends AdminController
{
    public function index()
    {

        // $startDate = Carbon::today(config('app.timezone'))->startOfDay();
        // $endDate = Carbon::today(config('app.timezone'))->endOfDay();
        // $dimensions = 'hour';
        // $period = Period::create($startDate, $endDate);

        // $answer = Analytics::performQuery($period, 'ga:visits,ga:pageviews', ['dimensions' => 'ga:' . $dimensions]);

        // if ($dimensions === 'hour') {
        //     foreach ($answer->rows as $dateRow) {
        //         $visitorData[] = [
        //             'axis' => (int) $dateRow[0] . 'h',
        //             'visitors' => $dateRow[1],
        //             'pageViews' => $dateRow[2],
        //         ];
        //     }
        // } else {
        //     foreach ($answer->rows as $dateRow) {
        //         $visitorData[] = [
        //             'axis' => Carbon::parse($dateRow[0])->toDateString(),
        //             'visitors' => $dateRow[1],
        //             'pageViews' => $dateRow[2],
        //         ];
        //     }
        // }

        // $stats = collect($visitorData);
        // $country_stats = Analytics::performQuery($period, 'ga:sessions', ['dimensions' => 'ga:countryIsoCode'])->rows;
        // $total = Analytics::performQuery($period, 'ga:sessions, ga:users, ga:pageviews, ga:percentNewSessions, ga:bounceRate, ga:pageviewsPerVisit, ga:avgSessionDuration, ga:newUsers')->totalsForAllResults;

        // dd(compact('stats', 'country_stats', 'total'));

        cms_load_widget_admin(); // run render widget

        $listAdminWidgets = get_list_widget_admin();
        $listWidget = [];
        foreach ($listAdminWidgets as $mod => $iWiget) {
            if ($iWiget) {
                foreach ($iWiget as $widgetItem) {
                    $widget = AdminWidget::where('name', $widgetItem['name'])->where('module', $mod)->first();
                    if ($widget) {
                        $listWidget[] = [
                            'name' => $widget['name'],
                            'title' => $widget['title'],
                            'module' => $widget['module'],
                            'order' => $widget['order'],
                            'status' => $widget['status'],
                            'group' => $widget['group']
                        ];
                    } else {
                        $listWidget[] = [
                            'name' => $widgetItem['name'],
                            'title' => $widgetItem['title'],
                            'module' => $mod,
                            'order' => 0,
                            'status' => 0,
                            'group' => 'TOP'
                        ];
                    }
                }
            }
        }

        $data['listWidget'] = $listWidget;
        return view('Admin::dashboard.index', $data);
    }

    public function saveWidgetAdmin(Request $request)
    {
        if ($request->has('widget')) {
            $listWidget = $request->widget; // get list widget from $request
            foreach ($listWidget as $mod => $arrWidget) {
                if ($arrWidget) {
                    foreach ($arrWidget as $widgetName => $iWidget) {
                        // init $widget
                        $widget = [
                            'order' => $iWidget['order'],
                            'status' => isset($iWidget['status']) ? 1 : 0,
                            'title' => $iWidget['title'],
                            'group' => $iWidget['group']
                        ];
                        $oldWidget = AdminWidget::where('module', $mod)->where('name', $widgetName)->first();
                        // check if has old widget in DB
                        if ($oldWidget) {
                            $oldWidget->fill($widget)->save(); // update
                        } else {
                            $widget['module'] = $mod;
                            $widget['name'] = $widgetName;
                            AdminWidget::create($widget); // create
                        }
                    }
                }
            }
        }
        Cache::forget('list_widget_admin');
        return redirect()->route('dashboard')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật widget thành công']);
    }
}