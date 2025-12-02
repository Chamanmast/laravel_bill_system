<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ItemsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Items', Item::count())
                ->description('All registered items')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning'),
        ];
    }
}
