<?php

namespace App\Filament\Resources\Shop\MarcaResource\Pages;

use App\Filament\Resources\Shop\MarcaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarcas extends ListRecords
{
    protected static string $resource = MarcaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
