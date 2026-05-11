<?php

// filepath: /home/vinsa/sekolah/project/laravel/vinsa.me/app/Filament/Resources/Orders/Widgets/OrderDayChart.php
namespace App\Filament\Resources\Orders\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Illuminate\Support\Carbon;

class OrderDayChart extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getHeading(): string
    {
        return 'Daily Orders (Last 7 Days)';
    }

    public function getMaxHeight(): ?string
    {
        return '280px';
    }

    protected function getData(): array
    {
        $labels = [];
        $totals = [];

        // Get last 7 days
        for ($i = 5; $i >= -1; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('D, d M');
            $totals[] = Order::whereDate('order_date', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Orders',
                    'data' => $totals,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.15)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}