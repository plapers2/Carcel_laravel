<?php

namespace App\Filament\Resources\Prisoners;

use App\Filament\Resources\Prisoners\Pages\CreatePrisoners;
use App\Filament\Resources\Prisoners\Pages\EditPrisoners;
use App\Filament\Resources\Prisoners\Pages\ListPrisoners;
use App\Filament\Resources\Prisoners\Schemas\PrisonersForm;
use App\Filament\Resources\Prisoners\Tables\PrisonersTable;
use App\Models\Prisoners;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PrisonersResource extends Resource
{
    protected static ?string $model = Prisoners::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PrisonersForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrisonersTable::configure($table);
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
            'index' => ListPrisoners::route('/'),
            'create' => CreatePrisoners::route('/create'),
            'edit' => EditPrisoners::route('/{record}/edit'),
        ];
    }
}
