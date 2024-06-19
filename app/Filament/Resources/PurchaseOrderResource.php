<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Filament\Resources\PurchaseOrderResource\RelationManagers;
use App\Models\OfferingLetter;
use App\Models\PurchaseOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Purchase Orders';

    protected static ?string $modelLabel = 'Purchase Orders';

    protected static ?string $navigationGroup = 'Document Data';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Purchase Order Information')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Purchase Order Number')
                            ->label('Purchase order number')
                            ->unique(ignoreRecord: true),
                        \Filament\Forms\Components\TextInput::make('pr_number')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Purchase Request Number')
                            ->unique(ignoreRecord: true),
                        \Filament\Forms\Components\DatePicker::make('date')
                            ->required()
                            ->label('Purchase order date')
                            ->placeholder('Purchase Order Date')
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('delivery_date')
                            ->required()
                            ->label('Purchase order delivery date')
                            ->placeholder('Purchase Order Delivery Date')
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('expired_date')
                            ->required()
                            ->label('Purchase order expiry date')
                            ->placeholder('Purchase Order Expiry Date')
                            ->native(false),
                    ])
                    ->columns(3),
                \Filament\Forms\Components\Section::make('Purchase Order Detail Information')
                    ->schema([
                        \Filament\Forms\Components\Select::make('offering_letter_id')
                            ->required()
                            ->options(OfferingLetter::all()->pluck('code', 'id'))
                            ->placeholder('Offering Letter')
                            ->label('Offering letter')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('supplier_company_name')
                            ->required()
                            ->maxLength(200)
                            ->placeholder('Supplier Company Name'),
                        \Filament\Forms\Components\TextInput::make('attendance')
                            ->required()
                            ->maxLength(200)
                            ->placeholder('Supplier Name')
                            ->label('Supplier name'),
                        \Filament\Forms\Components\TextArea::make('supplier_company_address')
                            ->required()
                            ->placeholder('Supplier Company Address')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('code')
                    ->label('Purchase Order Number')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('pr_number')
                    ->label('Purchase Request Number')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('date')
                    ->label('Purchase Order Date')
                    ->date(),
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
                \Filament\Tables\Filters\Filter::make('date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('po_date_start')
                            ->native(true),
                        \Filament\Forms\Components\DatePicker::make('po_date_until')
                            ->native(true),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['po_date_start'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date)
                            )
                            ->when(
                                $data['po_date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date)
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = array();
                        if ($data['po_date_start'] ?? null) {
                            $indicators['po_date_start'] = 'PO Date start '.\Carbon\Carbon::parse($data['po_date_start'])->toFormattedDateString();
                            $indicators['po_date_until'] = 'PO Date until '.\Carbon\Carbon::parse($data['po_date_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    })
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
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'view' => Pages\ViewPurchaseOrder::route('/{record}'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
