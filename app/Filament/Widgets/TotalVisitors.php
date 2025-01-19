<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TotalVisitors extends ApexChartWidget
{
    protected static ?string $chartId = 'totalVisitors';
    protected static ?string $heading = 'Total Visitors';
    protected static ?int $sort = 2;
    protected static ?int $contentHeight = 270;

    // Add this method to control visibility
    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => [7, 10, 13, 15, 18],
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }
}
