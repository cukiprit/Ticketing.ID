<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceLayoutResource\Pages;
use App\Filament\Resources\PlaceLayoutResource\RelationManagers;
use App\Forms\Components\SeatLayoutInput;
use App\Models\LayoutLokasi;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlaceLayoutResource extends Resource
{
    protected static ?string $model = LayoutLokasi::class;

    protected static ?string $navigationLabel = 'Layout Lokasi';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('event_id')
                    // ->relationship('event', 'acara')
                    ->label('Acara')
                    ->options(Event::where('status', 'published')->pluck('acara', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('jenis')
                    ->label('Jenis Layout (e.g., VIP, Reguler)')
                    ->required(),
                TextInput::make('kapasitas_total')
                    ->label('Kapasitas Total')
                    ->numeric()
                    ->columnSpanFull()
                    ->default(0)
                    ->required(),
                Repeater::make('layout_tenant')
                    ->label('Seat Config')
                    ->schema([
                        TextInput::make('id')
                            ->label('Seat ID (e.g., A1)')
                            ->required(),
                        TextInput::make('row')
                            ->label('Row (e.g., A)')
                            ->required(),
                        TextInput::make('number')
                            ->label('Seat Number (e.g., 1)')
                            ->numeric()
                            ->required(),
                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'available' => 'Available',
                                'booked' => 'Booked',
                                'blocked' => 'Blocked'
                            ])
                            ->default('available')
                            ->required()
                    ])
                    ->defaultItems(2)
                    ->createItemButtonLabel('Add seat')
                    ->collapsible()
                    ->columnSpanFull()
                    ->grid(2)
                    ->required()
                    ->afterStateHydrated(function($state, $set, $get){
                        if(is_null($state)){
                            $set('layout_tenant', []);
                        }
                    })
                    ->afterStateUpdated(function($state, $set, $get){
                        $set('kapasitas_total', count($get('layout_tenant')));
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.acara')->searchable(),
                TextColumn::make('jenis'),
                TextColumn::make('kapasitas_total')
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
            'index' => Pages\ListPlaceLayouts::route('/'),
            'create' => Pages\CreatePlaceLayout::route('/create'),
            'edit' => Pages\EditPlaceLayout::route('/{record}/edit'),
        ];
    }
}
