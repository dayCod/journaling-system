<?php

namespace App\Filament\Resources\PurchaseOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use App\Models\OfferingLetterItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PurchaseOrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'purchaseOrderItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make()
                    ->schema([
                        \Filament\Forms\Components\Select::make('offering_letter_item_id')
                            ->required()
                            ->options(
                                OfferingLetterItem::query()
                                    ->where('offering_letter_id', $this->getOwnerRecord()->offering_letter_id)
                                    ->get()
                                    ->pluck('vendorItem.name', 'id')
                            )
                            ->placeholder('Offering Letter Item')
                            ->label('Offering Letter Item')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->placeholder('Quantity')
                            ->numeric(),
                        \Filament\Forms\Components\TextInput::make('unit_price')
                            ->required()
                            ->label('Unit price')
                            ->placeholder('Unit Price')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $set('sub_total', number_format((int)str_replace(',', '', $state) * $get('quantity'), 0));
                            }),
                        \Filament\Forms\Components\TextInput::make('sub_total')
                            ->readOnly()
                            ->label('Sub total price')
                            ->placeholder('Sub Total Price')
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
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('offeringLetterItem.vendorItem.name')
                    ->label('Item Name')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity'),
                \Filament\Tables\Columns\TextColumn::make('unit_price')
                    ->label('Unit Price')
                    ->money('IDR'),
                \Filament\Tables\Columns\TextColumn::make('sub_total')
                    ->label('Sub Total')
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
