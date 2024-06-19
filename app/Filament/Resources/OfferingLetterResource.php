<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferingLetterResource\Pages;
use App\Filament\Resources\OfferingLetterResource\RelationManagers;
use App\Models\OfferingLetter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfferingLetterResource extends Resource
{
    protected static ?string $model = OfferingLetter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Offering Letters';

    protected static ?string $modelLabel = 'Offering Letters';

    protected static ?string $navigationGroup = 'Document Data';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Client Information')
                    ->schema([
                        \Filament\Forms\Components\Select::make('office_id')
                            ->required()
                            ->relationship(name: 'office', titleAttribute: 'name')
                            ->placeholder('Office Name')
                            ->searchable()
                            ->preload(),
                        \Filament\Forms\Components\TextInput::make('attendance')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Office PIC / Purchasing Field'),
                    ])
                    ->columns(2),
                \Filament\Forms\Components\Section::make('Offering Letter Information')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Offering Letter Code'),
                        \Filament\Forms\Components\TextInput::make('sales_manager')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Sales Representative Name'),
                        \Filament\Forms\Components\TextInput::make('sales_manager_phone')
                            ->required()
                            ->maxLength(25)
                            ->placeholder('Sales Representative Phone Number')
                            ->prefix('+62'),
                        \Filament\Forms\Components\RichEditor::make('note')
                            ->required()
                            ->placeholder('Offering Letter Note')
                            ->toolbarButtons([
                                'bold',
                                'bulletList',
                                'italic',
                                'orderedList',
                                'underline',
                            ])
                            ->columnSpanFull()
                    ])
                    ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('code')
                    ->label('Offering Letter Code')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('office.name')
                    ->label('Customer Office / Plant')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('attendance')
                    ->label('Customer PIC / Purchasing')
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
            'index' => Pages\ListOfferingLetters::route('/'),
            'create' => Pages\CreateOfferingLetter::route('/create'),
            'view' => Pages\ViewOfferingLetter::route('/{record}'),
            'edit' => Pages\EditOfferingLetter::route('/{record}/edit'),
        ];
    }
}
