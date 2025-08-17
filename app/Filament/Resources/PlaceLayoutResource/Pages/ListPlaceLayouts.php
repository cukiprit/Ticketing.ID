<?php

namespace App\Filament\Resources\PlaceLayoutResource\Pages;

use App\Filament\Resources\PlaceLayoutResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaceLayouts extends ListRecords
{
    protected static string $resource = PlaceLayoutResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
