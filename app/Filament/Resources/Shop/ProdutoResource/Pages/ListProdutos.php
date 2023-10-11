<?php

namespace App\Filament\Resources\Shop\ProdutoResource\Pages;

use App\Filament\Resources\Shop\ProdutoResource;
use Filament\Pages\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListProdutos extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ProdutoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ProdutoResource::getWidgets();
    }
}
