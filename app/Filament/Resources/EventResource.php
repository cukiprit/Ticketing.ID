<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Symfony\Component\Console\Descriptor\TextDescriptor;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('acara')->required(),
                TextInput::make('lokasi')->required(),
                DatePicker::make('tanggal_acara')->default(now()),
                Select::make('status')->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'cancelled' => 'Cancelled'
                ])->default('draft'),
                Textarea::make('deskripsi')->required()->columnSpanFull()->rows(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('acara')->searchable(),
                TextColumn::make('tanggal_acara')->date(),
                BadgeColumn::make('status')
                    ->enum([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Reviewing',
                    ])
                    ->colors([
                        'primary',
                        'secondary' => 'draft',
                        'success' => 'published',
                        'danger' => 'cancelled'
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
