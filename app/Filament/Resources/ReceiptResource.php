<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptResource\Pages;
use App\Filament\Resources\ReceiptResource\RelationManagers;
use App\Models\Receipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Receipts';

    protected static ?string $modelLabel = 'Receipts';

    protected static ?string $navigationGroup = 'Document Data';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Receipt Information')
                    ->schema([
                        \Filament\Forms\Components\Select::make('purchase_order_id')
                            ->required()
                            ->relationship(name: 'purchaseOrder', titleAttribute: 'code')
                            ->searchable()
                            ->preload()
                            ->label('Purchase order')
                            ->placeholder('Purchase Order'),
                        \Filament\Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Receipt Number')
                            ->label('Receipt number')
                            ->unique(ignoreRecord: true),
                        \Filament\Forms\Components\TextInput::make('to_company_target')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Client Company')
                            ->label('Client company'),
                        \Filament\Forms\Components\TextInput::make('company_target_address')
                            ->required()
                            ->placeholder('Client Company Address')
                            ->label('Company company address')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
                \Filament\Forms\Components\Section::make('Receipt Detail Information')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('bod_name')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Supplier BOD Name')
                            ->label('Supplier BOD name'),
                        \Filament\Forms\Components\TextInput::make('position')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Supplier BOD Position')
                            ->label('Supplier BOD position'),
                        \Filament\Forms\Components\TextInput::make('bank_name')
                            ->required()
                            ->placeholder('Supplier Bank Name')
                            ->label('Supplier bank name'),
                        \Filament\Forms\Components\TextInput::make('bank_account_number')
                            ->required()
                            ->placeholder('Supplier Bank Account Number')
                            ->label('Supplier bank account number'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('code')
                    ->label('Receipt Number')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('purchaseOrder.code')
                    ->label('Purchase Order Number')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('purchaseOrder.pr_number')
                    ->label('Purchase Order PR Number')
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
                \Filament\Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_from'),
                        \Filament\Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
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
            'index' => Pages\ListReceipts::route('/'),
            'create' => Pages\CreateReceipt::route('/create'),
            'view' => Pages\ViewReceipt::route('/{record}'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}
