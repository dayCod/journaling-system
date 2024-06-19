<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Vendors';

    protected static ?string $modelLabel = 'Vendors';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make()
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Vendor Name')
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('account_number')
                            ->placeholder('Vendor Account Number'),
                        \Filament\Forms\Components\Select::make('bank_id')
                            ->placeholder('Vendor Bank')
                            ->relationship(name: 'bank', titleAttribute: 'name')
                            ->searchable()
                            ->preload(),
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
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Vendor Name')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('address')
                    ->label('Vendor Address')
                    ->limit(30)
                    ->formatStateUsing(fn ($state) => $state ?? '')
                    ->tooltip(fn (Vendor $record) => $record->address),
                \Filament\Tables\Columns\TextColumn::make('account_number')
                    ->label('Vendor Account Number')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('bank.name')
                    ->label('Vendor Bank Name')
                    ->searchable(),
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
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'view' => Pages\ViewVendor::route('/{record}'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
