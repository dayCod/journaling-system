<?php

namespace App\Filament\Resources\OfferingLetterResource\Pages;

use App\Filament\Resources\OfferingLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfferingLetters extends ListRecords
{
    protected static string $resource = OfferingLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
