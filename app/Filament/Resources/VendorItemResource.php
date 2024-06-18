<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorItemResource\Pages;
use App\Filament\Resources\VendorItemResource\RelationManagers;
use App\Models\VendorItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
