<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Event;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Number;

class DashboardOverview extends StatsOverviewWidget
{
    // protected static string $view = 'filament.widgets.dashboard';

    protected function getCards(): array
    {
        return [
            Card::make('Total Events', Event::count())
                ->icon('heroicon-o-calendar')
                ->description('Semua events yang dibuat')
                ->color('primary'),

            Card::make('Booking Terkonfirmasi', Booking::where('status', 'confirmed')->count())
                ->icon('heroicon-o-check-circle')
                ->description('Berhasil dibooking')
                ->color('success'),
        ];
    }
}
