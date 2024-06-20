<?php

namespace App\Filament\Resources\TravelDocumentResource\Pages;

use App\Filament\Resources\TravelDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTravelDocuments extends ListRecords
{
    protected static string $resource = TravelDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
