<?php

namespace App\Filament\Resources\TravelDocumentResource\Pages;

use App\Filament\Resources\TravelDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTravelDocument extends EditRecord
{
    protected static string $resource = TravelDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
