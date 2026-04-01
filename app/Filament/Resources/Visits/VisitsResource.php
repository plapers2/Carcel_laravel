<?php

namespace App\Filament\Resources\Visits;

use App\Filament\Resources\Visits\Pages\CreateVisits;
use App\Filament\Resources\Visits\Pages\EditVisits;
use App\Filament\Resources\Visits\Pages\ListVisits;
use App\Filament\Resources\Visits\Schemas\VisitsForm;
use App\Filament\Resources\Visits\Tables\VisitsTable;
use App\Models\Visits;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VisitsResource extends Resource
{
    protected static ?string $model = Visits::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Calendar;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return VisitsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitsTable::configure($table);
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
            'index' => ListVisits::route('/'),
            'create' => CreateVisits::route('/create'),
        ];
    }
}
