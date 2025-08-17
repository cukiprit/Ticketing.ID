<?php

namespace App\Filament\Resources\PlaceLayoutResource\Pages;

use App\Filament\Resources\PlaceLayoutResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlaceLayout extends EditRecord
{
    protected static string $resource = PlaceLayoutResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
