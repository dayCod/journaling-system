<?php

namespace App\Filament\Resources\OfferingLetterResource\Pages;

use App\Filament\Resources\OfferingLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOfferingLetter extends ViewRecord
{
    protected static string $resource = OfferingLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
