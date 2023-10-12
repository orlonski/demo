<?php

namespace App\Filament\Resources\ProdutoResource\Pages;

use App\Filament\Resources\ProdutoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduto extends EditRecord
{
    protected static string $resource = ProdutoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
