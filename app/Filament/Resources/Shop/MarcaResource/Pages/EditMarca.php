<?php

namespace App\Filament\Resources\Shop\MarcaResource\Pages;

use App\Filament\Resources\Shop\MarcaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarca extends EditRecord
{
    protected static string $resource = MarcaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
