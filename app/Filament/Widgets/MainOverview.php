<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MainOverview extends BaseWidget
{
    protected int | array | null $columns = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', 200)
                ->description('All registered customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

        ];
    }
}
