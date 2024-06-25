<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Invoices';

    protected static ?string $modelLabel = 'Invoices';

    protected static ?string $navigationGroup = 'Document Data';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make()
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
                            ->placeholder('Invoice Number')
                            ->label('Invoice number')
                            ->unique(ignoreRecord: true)
                            ->columnSpan(2),
                        \Filament\Forms\Components\TextInput::make('to_company_target')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Client Company & Regency')
                            ->label('Client company & regency'),
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
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('code')
                    ->label('Invoice Number')
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
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-on-square-stack')
                    ->url(fn (Invoice $invoice) => route('pdf.invoice', $invoice))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('View PO Detail')
                    ->label('View PO Detail')
                    ->color('success')
                    ->icon('heroicon-o-eye')
                    ->url(
                        fn (Invoice $invoice)
                            => route('filament.admin.resources.purchase-orders.view', $invoice->purchaseOrder)
                    )
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
