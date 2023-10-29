<?php

namespace App\Filament\Resources\ProdutoFornecedorResource\Pages;

use App\Filament\Resources\ProdutoFornecedorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProdutoFornecedors extends ListRecords
{
    protected static string $resource = ProdutoFornecedorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
