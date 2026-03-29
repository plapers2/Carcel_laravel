<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Spatie\Permission\Models\Permission;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                CheckboxList::make('permissions')
                    ->relationship('permissions', 'name')
                    ->columns(3),
            ]);
    }
}
