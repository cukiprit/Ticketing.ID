<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;

class BottomDashboardOverview extends StatsOverviewWidget
{
    // protected static string $view = 'filament.widgets.bottom-dashboard-overview';

    protected function getCards(): array
    {
        return [
            Card::make('Booking Pending', Booking::where('status', 'pending')->count())
                ->icon('heroicon-o-clock')
                ->description('Menunggu Konfirmasi')
                ->color('warning'),

            Card::make('Booking Dibatalkan', Booking::where('status', 'cancelled')->count())
                ->icon('heroicon-o-x-circle')
                ->description('Booking dibatalkan')
                ->color('danger'),

            Card::make('Total Keuntungan', 'RP. ' . number_format(Booking::where('status', 'confirmed')->sum('total'), 0, ',', '.'))
                ->icon('heroicon-o-currency-dollar')
                ->description('Dari Booking yang terkonfirmasi')
                ->color('success'),
        ];
    }
}
