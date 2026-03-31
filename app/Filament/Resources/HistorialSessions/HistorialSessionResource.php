<?php

namespace App\Filament\Resources\HistorialSessions;

use App\Filament\Resources\HistorialSessions\Pages\CreateHistorialSession;
use App\Filament\Resources\HistorialSessions\Pages\EditHistorialSession;
use App\Filament\Resources\HistorialSessions\Pages\ListHistorialSessions;
use App\Filament\Resources\HistorialSessions\Schemas\HistorialSessionForm;
use App\Filament\Resources\HistorialSessions\Tables\HistorialSessionsTable;
use App\Models\HistorialSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HistorialSessionResource extends Resource
{
    protected static ?string $model = HistorialSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;

    protected static ?string $recordTitleAttribute = 'user.name';

    public static function form(Schema $schema): Schema
    {
        return HistorialSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HistorialSessionsTable::configure($table);
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
            'index' => ListHistorialSessions::route('/'),
        ];
    }
}
