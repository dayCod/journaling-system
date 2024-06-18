<?php

namespace App\Filament\Resources\VendorItemResource\Pages;

use App\Filament\Resources\VendorItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVendorItem extends EditRecord
{
    protected static string $resource = VendorItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
