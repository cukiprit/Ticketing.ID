<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BottomDashboardOverview;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\DashboardOverview;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            DashboardOverview::class,
            BottomDashboardOverview::class
            // BookingsChart::class,
            // Add other widgets as needed
        ];
    }

    protected function getColumns(): int|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'lg' => 2, // Adjust based on how many cards you have
        ];
    }
}
