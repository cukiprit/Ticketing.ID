<?php

namespace App\Filament\Resources\SeatResource\Pages;

use App\Filament\Resources\SeatResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeats extends ListRecords
{
    protected static string $resource = SeatResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
