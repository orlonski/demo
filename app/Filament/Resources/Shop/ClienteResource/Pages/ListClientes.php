<?php

namespace App\Filament\Resources\Shop\ClienteResource\Pages;

use App\Filament\Resources\Shop\ClienteResource;
use Filament\Pages\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListClientes extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ClienteResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ClienteResource::getWidgets();
    }

}