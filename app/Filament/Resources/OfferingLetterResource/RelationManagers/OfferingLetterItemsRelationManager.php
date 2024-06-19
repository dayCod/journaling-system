<?php

namespace App\Filament\Resources\OfferingLetterResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OfferingLetterItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'offeringLetterItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make()
                    ->schema([
                        \Filament\Forms\Components\Select::make('vendor_item_id')
                            ->required()
                            ->relationship(name: 'vendorItem', titleAttribute: 'name')
                            ->placeholder('Vendor Item')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->placeholder('Quantity')
                            ->numeric(),
                        \Filament\Forms\Components\TextInput::make('retail_price_per_item')
                            ->required()
                            ->label('Price')
                            ->placeholder('Price')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $set('total_price_per_item', number_format((int)str_replace(',', '', $state) * $get('quantity'), 0));
                            }),
                        \Filament\Forms\Components\TextInput::make('total_price_per_item')
                            ->readOnly()
                            ->label('Total Price')
                            ->placeholder('Total Price')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                    ])
                    ->columns(3)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('vendorItem.name')
                    ->label('Item Name')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity'),
                \Filament\Tables\Columns\TextColumn::make('retail_price_per_item')
                    ->label('Price')
                    ->money('IDR'),
                \Filament\Tables\Columns\TextColumn::make('total_price_per_item')
                    ->label('Total Price')
                    ->money('IDR'),
                \Filament\Tables\Columns\TextColumn::make('pnl')
                    ->label('Per Item P/L')
                    ->badge()
                    ->color(function (string $state) {
                        return Str::contains($state, '+') ? 'success' : 'danger';
                    }),
                \Filament\Tables\Columns\TextColumn::make('total_pnl')
                    ->label('Total P/L')
                    ->badge()
                    ->color(function (string $state) {
                        return Str::contains($state, '+') ? 'success' : 'danger';
                    }),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
