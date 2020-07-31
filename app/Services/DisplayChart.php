<?php


namespace App\Services;


use App\Charts\PriceHistoryChart;
use App\PriceQuantityHistory;

class DisplayChart
{
    public function priceChart($product)
    {
        $price_history = PriceQuantityHistory::where('product_id', $product->id)->pluck('updated_at', 'price');

        $up_to_90days_old = [];

        foreach ($price_history as $price => $date) {

            $now = new \DateTime(now());
            $editing_day = new \DateTime($date);
            $difference = $editing_day->diff($now);
            if ($difference->days < 90) {
                $up_to_90days_old[$price] = $date;
                asort($up_to_90days_old);
            }
        }

        $price_chart = new PriceHistoryChart;
        $price_chart->labels(array_values($up_to_90days_old));
        $price_chart->dataset('Price history of the last 90 days', 'line', array_keys($up_to_90days_old));

        return $price_chart;
    }

    public function quantityChart($product)
    {
        $quantity_history = PriceQuantityHistory::where('product_id', $product->id)->pluck('updated_at', 'quantity');

        $up_to_90days_old = [];

        foreach ($quantity_history as $quantity => $date) {

            $now = new \DateTime(now());
            $editing_day = new \DateTime($date);
            $difference = $editing_day->diff($now);
            if ($difference->days < 90) {
                $up_to_90days_old[$quantity] = $date;
                asort($up_to_90days_old);
            }
        }

        $quantity_chart = new PriceHistoryChart;
        $quantity_chart->labels(array_values($up_to_90days_old));
        $quantity_chart->dataset('Quantity history of the last 90 days', 'line', array_keys($up_to_90days_old));

        return $quantity_chart;
    }
}
