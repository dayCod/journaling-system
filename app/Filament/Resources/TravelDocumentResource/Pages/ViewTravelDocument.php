<?php

namespace App\Filament\Resources\TravelDocumentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TravelDocumentResource;

class ViewTravelDocument extends ViewRecord
{

    protected static string $resource = TravelDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
