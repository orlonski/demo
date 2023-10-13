<?php

namespace App\Filament\Resources\FormaPagamentoResource\Pages;

use App\Filament\Resources\FormaPagamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormaPagamento extends EditRecord
{
    protected static string $resource = FormaPagamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
