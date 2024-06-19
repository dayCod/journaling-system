<?php

namespace App\Filament\Resources\OfferingLetterResource\Pages;

use App\Filament\Resources\OfferingLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfferingLetter extends EditRecord
{
    protected static string $resource = OfferingLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
