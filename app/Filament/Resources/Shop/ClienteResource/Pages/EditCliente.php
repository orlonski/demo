<?php

namespace App\Filament\Resources\Shop\ClienteResource\Pages;

use App\Filament\Resources\Shop\ClienteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCliente extends EditRecord
{
    protected static string $resource = ClienteResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
