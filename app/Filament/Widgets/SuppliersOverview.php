<?php

namespace App\Filament\Widgets;

use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuppliersOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Suppliers', Supplier::count())
                ->description('All registered suppliers')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),
        ];
    }
}
