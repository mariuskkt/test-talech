<?php

namespace App\Http\Controllers;

use App\PriceQuantityHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Charts\PriceHistoryChart;

class GraphController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index(Request $request)
    {
        $price_history = PriceQuantityHistory::where('product_id', 1)->pluck('updated_at', 'price');

        $up_to_90days_old = [];

        foreach ($price_history as $price => $date) {

            $now = new \DateTime(now());
            $editing_day = new \DateTime($date);
            $difference = $editing_day->diff($now);
            if ($difference->days < 90) {
                $up_to_90days_old[$price] = $date;
            }
        }

        $chart = new PriceHistoryChart;
        $chart->labels(array_values($up_to_90days_old));
        $chart->dataset('Price history of the last 90 days', 'line', array_keys($up_to_90days_old));
        return view('graph', compact('chart'));
    }

    public function quantity(Request $request)
    {
        $quantity_history = PriceQuantityHistory::where('product_id', 1)->pluck('updated_at', 'quantity');

        $up_to_90days_old = [];

        foreach ($quantity_history as $quantity => $date) {

            $now = new \DateTime(now());
            $editing_day = new \DateTime($date);
            $difference = $editing_day->diff($now);
            if ($difference->days < 90) {
                $up_to_90days_old[$quantity] = $date;
            }
        }

        $chart = new PriceHistoryChart;
        $chart->labels(array_values($up_to_90days_old));
        $chart->dataset('Quantity history of the last 90 days', 'line', array_keys($up_to_90days_old));
        return view('graph', compact('chart'));
    }
}
