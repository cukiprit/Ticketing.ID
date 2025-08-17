<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class SeatLayoutInput extends Field
{
    protected string $view = 'forms.components.seat-layout-input';

    protected array $seatData = [];

    public function seatData(array $data): static
    {
        $this->seatData = $data;

        return $this;
    }

    public function getSeatData(): array
    {
        return $this->seatData;
    }
}
