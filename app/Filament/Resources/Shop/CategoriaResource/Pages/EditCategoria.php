<?php

namespace App\Filament\Resources\Shop\CategoriaResource\Pages;

use App\Filament\Resources\Shop\CategoriaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoria extends EditRecord
{
    protected static string $resource = CategoriaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
