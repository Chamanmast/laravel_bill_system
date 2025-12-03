<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MainOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::count())
                ->description('All registered customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Items', Item::count())
                ->description('All registered items')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning'),
            Stat::make('Total Suppliers', Supplier::count())
                ->description('All registered suppliers')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),
        ];
    }
}
