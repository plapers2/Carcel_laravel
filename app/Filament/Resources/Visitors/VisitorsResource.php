<?php

namespace App\Filament\Resources\Visitors;

use App\Filament\Resources\Visitors\Pages\CreateVisitors;
use App\Filament\Resources\Visitors\Pages\EditVisitors;
use App\Filament\Resources\Visitors\Pages\ListVisitors;
use App\Filament\Resources\Visitors\Schemas\VisitorsForm;
use App\Filament\Resources\Visitors\Tables\VisitorsTable;
use App\Models\Visitors;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VisitorsResource extends Resource
{
    protected static ?string $model = Visitors::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return VisitorsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitorsTable::configure($table);
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
            'index' => ListVisitors::route('/'),
            'create' => CreateVisitors::route('/create'),
            'edit' => EditVisitors::route('/{record}/edit'),
        ];
    }
}
