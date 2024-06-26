<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PurchaseOrder;
use App\Models\OfferingLetter;
use App\Models\TravelDocument;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Filament\Resources\PurchaseOrderResource\RelationManagers;
use App\Filament\Resources\PurchaseOrderResource\RelationManagers\PurchaseOrderItemsRelationManager;

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
                        \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('po_attachments')
                            ->multiple()
                            ->reorderable()
                            ->openable()
                            ->columnSpanFull()
                            ->label('Purchase order attachments'),
                    ])
                    ->columns(2),
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
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Purchase Order Date')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'process' => 'warning',
                        'complete' => 'success',
                    }),
                \Filament\Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('IDR')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('total_vat')
                    ->label('Total VAT')
                    ->money('IDR')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->money('IDR')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('capital_return_percentage')
                    ->label('Return Percentage From Capital')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('profit_margin')
                    ->label('Profit Margin')
                    ->money('IDR')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('purchase_capital')
                    ->label('Purchase Capital')
                    ->money('IDR')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('updateStatusProcessed')
                        ->hidden(fn (Model $record) => !is_null($record->process_datetime))
                        ->label('Set Status to Process')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->form([
                            \Filament\Forms\Components\DatePicker::make('process_datetime')
                                ->required()
                                ->label('Process Date')
                                ->native(false),
                        ])
                        ->action(function (array $data, PurchaseOrder $record): void {
                            $record->status = 'process';
                            $record->process_datetime = $data['process_datetime'];
                            $record->save();
                        })
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Status Changed')
                                ->body('PO Status was changed to Process')
                        ),
                    Tables\Actions\Action::make('updateStatusCompleted')
                        ->hidden(fn (Model $record) => is_null($record->process_datetime))
                        ->label('Set Status to Complete')
                        ->icon('heroicon-o-check')
                        ->form([
                            \Filament\Forms\Components\DatePicker::make('complete_datetime')
                                ->required()
                                ->label('Process Date')
                                ->native(false),
                        ])
                        ->action(function (array $data, PurchaseOrder $record): void {
                            $record->status = 'complete';
                            $record->complete_datetime = $data['complete_datetime'];
                            $record->save();
                        })
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Status Changed')
                                ->body('PO Status was changed to Complete')
                        ),
                ])
                ->hidden(fn (Model $record) => $record->status == 'complete'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Travel Document')
                        ->hidden(fn (Model $record) => empty($record->travelDocument))
                        ->label('View Travel Document')
                        ->icon('heroicon-o-eye')
                        ->url(
                            fn (Model $record)
                                => route('filament.admin.resources.travel-documents.view', $record->travelDocument)
                        )
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('Invoice')
                        ->hidden(fn (Model $record) => empty($record->invoice))
                        ->label('View Invoice')
                        ->icon('heroicon-o-eye')
                        ->url(
                            fn (Model $record)
                                => route('filament.admin.resources.invoices.view', $record->invoice)
                        )
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('Receipt')
                        ->hidden(fn (Model $record) => empty($record->receipt))
                        ->label('View Receipt')
                        ->icon('heroicon-o-eye')
                        ->url(
                            fn (Model $record)
                                => route('filament.admin.resources.receipts.view', $record->receipt)
                        )
                        ->openUrlInNewTab(),
                ])
                ->hidden(fn (Model $record) => $record->status != 'complete'),
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
            PurchaseOrderItemsRelationManager::class,
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
