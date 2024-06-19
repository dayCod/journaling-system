<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorItemResource\Pages;
use App\Filament\Resources\VendorItemResource\RelationManagers;
use App\Models\VendorItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VendorItemResource extends Resource
{
    protected static ?string $model = VendorItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Vendor Items';

    protected static ?string $modelLabel = 'Vendor Items';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make()
                    ->schema([
                        \Filament\Forms\Components\Select::make('vendor_id')
                            ->required()
                            ->placeholder('Vendor')
                            ->relationship(name: 'vendor', titleAttribute: 'name')
                            ->searchable()
                            ->preload(),
                        \Filament\Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Vendor Item Name'),
                        \Filament\Forms\Components\TextInput::make('price')
                            ->required()
                            ->placeholder('Vendor Item Price')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                        \Filament\Forms\Components\TextInput::make('code')
                            ->maxLength(50)
                            ->placeholder('Vendor Item Code')
                            ->unique(ignoreRecord: true),
                        \Filament\Forms\Components\Textarea::make('address')
                            ->placeholder('Vendor Address')
                            ->columnSpanFull()
                            ->rows(4),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('vendor.name')
                    ->label('Vendor Name')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Vendor Item Name')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('price')
                    ->label('Vendor Item Price')
                    ->searchable()
                    ->money('IDR'),
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
                \Filament\Tables\Filters\SelectFilter::make('Vendor')
                    ->relationship(name: 'vendor', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by Vendor')
                    ->indicator('Vendor'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListVendorItems::route('/'),
            'create' => Pages\CreateVendorItem::route('/create'),
            'view' => Pages\ViewVendorItem::route('/{record}'),
            'edit' => Pages\EditVendorItem::route('/{record}/edit'),
        ];
    }
}
