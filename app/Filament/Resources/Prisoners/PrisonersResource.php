<?php

namespace App\Filament\Resources\Prisoners;

use App\Filament\Resources\Prisoners\Pages\CreatePrisoners;
use App\Filament\Resources\Prisoners\Pages\EditPrisoners;
use App\Filament\Resources\Prisoners\Pages\ListPrisoners;
use App\Filament\Resources\Prisoners\Pages\ViewPrisoners;
use App\Filament\Resources\Prisoners\Schemas\PrisonersForm;
use App\Filament\Resources\Prisoners\Schemas\PrisonersInfolist;
use App\Filament\Resources\Prisoners\Tables\PrisonersTable;
use App\Models\prisoners;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\PrisioneroResource\RelationManagers\VisitasRelationManager;

class PrisonersResource extends Resource
{
    protected static ?string $model = prisoners::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::LockClosed;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PrisonersForm::configure($schema);
    }




    public static function infolist(Schema $schema): Schema
    {
        return PrisonersInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrisonersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            VisitasRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrisoners::route('/'),
            'create' => CreatePrisoners::route('/create'),
            'view' => ViewPrisoners::route('/{record}'),
            'edit' => EditPrisoners::route('/{record}/edit'),
        ];
    }
}
