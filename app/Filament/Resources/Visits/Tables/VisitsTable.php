<?php

namespace App\Filament\Resources\Visits\Tables;

use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->defaultSort('start_date', 'desc')
            ->columns([
                TextColumn::make('visitor_relationship')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('start_date')
                    ->dateTime()
                    ->searchable()
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->sortable(),
                TextColumn::make('end_date')
                    ->dateTime()
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->searchable()
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
                    ->wrap()
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('visitor.name')
                    ->wrap()
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->wrap()
                    ->numeric()
                    ->searchable()
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
                SelectFilter::make('verification')
                    ->options([
                        'Pending' => 'Pending',
                        'Approve' => 'Approved',
                        'In progress' => 'In Progress',
                        'Finished' => 'Finished',
                        'Rejected' => 'Rejected',
                    ]),
                Filter::make('today')
                    ->label('Today only')
                    ->query(fn($query) => $query->whereDate('start_date', today())),
            ])
            ->recordActions([
                Action::make('approve')
                    ->requiresConfirmation()
                    ->modalHeading('Approve visit?')
                    ->modalDescription('This will allow the visitor to enter.')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn($record) => $record->verification === 'Pending')
                    ->action(fn($record) => $record->update(['verification' => 'Approved'])),

                Action::make('reject')
                    ->requiresConfirmation()
                    ->modalHeading('Reject visit?')
                    ->modalDescription('This will deny the visitor entry.')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn($record) => in_array($record->verification, ['Pending', 'Approved']))
                    ->action(fn($record) => $record->update(['verification' => 'Rejected'])),


                Action::make('finish')
                    ->requiresConfirmation()
                    ->modalHeading('Finish visit?')
                    ->modalDescription('Mark this visit as completed.')
                    ->label('Finish')
                    ->color('warning')
                    ->icon('heroicon-o-flag')
                    ->visible(fn($record) => $record->verification === 'In progress')
                    ->action(fn($record) => $record->update(['verification' => 'Finished'])),
            ]);
    }
}
