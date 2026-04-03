<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MainOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static ?int $navigationSort = 1;

    public function getHeaderWidgets(): array
    {
        return [];
    }

    public function getColumns(): int|array
    {
        return 3;
    }

    public function getWidgets(): array
    {
        return [
            MainOverview::class,
        ];
    }
}
