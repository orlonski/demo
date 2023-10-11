<?php

namespace App\Filament\Resources\Shop\PedidoResource\Pages;

use App\Filament\Resources\Shop\PedidoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPedido extends EditRecord
{
    protected static string $resource = PedidoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
