<?php

namespace App\Http\Controllers\Chart;

use App\Model\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;

class ChartController extends Controller {
    public function orderChartByYear (Request $request) {
        $year = (new DateTime)->format('Y');

        if ($request->isMethod('post')) {
            $year = $request->get('year');
        }

        $countOrder = array();
        $colorPerMonth = array();
        $totalPerMonth = array();
        $total = 0;

        for ($month = 1; $month < 13; $month++) {
            $orderPerMonth = Payment::where('payment_status', 'PAID')
                                    ->whereMonth('created_at', $month)
                                    ->whereYear('created_at', $year)->get();

            foreach ($orderPerMonth as $order) {
                $total += $order->payment_total;
            }

            $totalPerMonth[] = $total;
            $total = 0;
            $countOrder[] = count($orderPerMonth);
            $colorPerMonth[] = $this->rand_color();
        }

        return view('admin.chart.statistic-per-year', ['countOrderPerMonth' => $countOrder,
            'colorPerMonth' => $colorPerMonth,
            'yearSummary' => $year,
            'totalPerMonth' => $totalPerMonth]);
    }

    public function orderChartByMonth (Request $request) {
        $year = (new DateTime)->format('Y');
        $month = (int) (new DateTime)->format('m');

        if ($request->isMethod('post')) {
            $year = $request->get('year');
            $month = $request->get('month');
        }

        $countOrder = array();
        $colorPerMonth = array();
        $totalPerMonth = array();
        $total = 0;
        $monthList = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        for ($date = 1; $date < 30; $date++) {
            $orderPerMonth[$date] = Payment::where('payment_status', 'PAID')
                                           ->whereDay('created_at', $date)
                                           ->whereMonth('created_at', $month)
                                           ->whereYear('created_at', $year)->get();

            foreach ($orderPerMonth[$date] as $order) {
                $total += $order->payment_total;
            }

            $totalPerMonth[] = $total;
            $total = 0;
            $countOrder[] = count($orderPerMonth[$date]);
            $colorPerMonth[] = $this->rand_color();
        }

        return view('admin.chart.statistic-per-month',
            [
                'countOrderPerMonth' => $countOrder,
                'colorPerMonth' => $colorPerMonth,
                'yearSummary' => $year,
                'monthSummary' => $month,
                'totalPerMonth' => $totalPerMonth,
                'monthList' => $monthList
            ]
        );
    }

    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}
