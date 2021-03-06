<?php

namespace App\Domain\Report\Tabulator;

use MathPHP\Statistics\Average;
use App\Domain\Math\Statistics;

class IterationTabulator
{
    public function chart(array $dataSet)
    {
        $data = [];
        $labels = array_map(function (array $data) {
            return $data['iteration'];
        }, $dataSet);

        $series = array_map(function (array $data) {
            return $data['time-net'];
        }, $dataSet);

        return [
            'labels' => $labels,
            'series' => $series,
            'mean' => Average::mean($series),
        ];
    }

    public function histogram(array $dataSet)
    {
        $series = array_map(function (array $data) {
            return $data['time-net'];
        }, $dataSet);
        $histogram = Statistics::histogram($series, 25);

        return [
            'labels' => array_keys($histogram),
            'series' => array_values($histogram),
            'mean' => Average::mean($series),
        ];
    }
}
