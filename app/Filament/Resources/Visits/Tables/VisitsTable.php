<?php

namespace App\Filament\Resources\Visits\Tables;

use App\Filament\Resources\Visits\VisitsResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                TextColumn::make('visitor_relationship')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->dateTime()
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->sortable(),
                TextColumn::make('end_date')
                    ->dateTime()
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->sortable(),
                TextColumn::make('verification')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Pending'     => 'heroicon-o-clock',
                        'Approved'     => 'heroicon-o-check-circle',
                        'In progress' => 'heroicon-o-arrow-path',
                        'Finished'    => 'heroicon-o-check-badge',
                        'Rejected'    => 'heroicon-o-x-circle',
                        default       => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn(string $state) => match ($state) {
                        'Pending' => 'warning',
                        'Approved' => 'info',
                        'In progress' => 'primary',
                        'Finished' => 'success',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('prisoner.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('visitor.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn($record) => $record->verification === 'Pending')
                    ->action(fn($record) => $record->update(['verification' => 'Approved'])),

                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn($record) => in_array($record->verification, ['Pending', 'Approved']))
                    ->action(fn($record) => $record->update(['verification' => 'Rejected'])),


                Action::make('finish')
                    ->label('Finish')
                    ->color('warning')
                    ->icon('heroicon-o-flag')
                    ->visible(fn($record) => $record->verification === 'In progress')
                    ->action(fn($record) => $record->update(['verification' => 'Finished'])),
            ]);
    }
}
