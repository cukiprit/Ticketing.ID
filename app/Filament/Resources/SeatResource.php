<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeatResource\Pages;
use App\Filament\Resources\SeatResource\RelationManagers;
use App\Models\LayoutLokasi;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeatResource extends Resource
{
    protected static ?string $model = LayoutLokasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getPluralLabel(): string
    {
        return 'Layout Lokasi';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('event_id')
                    ->label('Acara')
                    ->options(Event::where('status', 'published')->pluck('acara', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('section')
                    ->label('Tipe Seat (e.g. VIP, Reguler)')
                    ->required(),
                TextInput::make('row')
                    ->label('Baris')
                    ->required(),
                TextInput::make('number')
                    ->label('Nomor')
                    ->numeric()
                    ->required(),
                TextInput::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp.')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Available',
                        'booked' => 'Booked',
                        'blocked' => 'Blocked'
                    ])
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.acara')->searchable(),
                TextColumn::make('section')->searchable(),
                TextColumn::make('row'),
                TextColumn::make('number'),
                BadgeColumn::make('status')
                ->colors([
                    'primary',
                    'warning' => 'booked',
                    'success' => 'available',
                    'danger' => 'blocked',
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeats::route('/'),
            'create' => Pages\CreateSeat::route('/create'),
            'edit' => Pages\EditSeat::route('/{record}/edit'),
        ];
    }
}
