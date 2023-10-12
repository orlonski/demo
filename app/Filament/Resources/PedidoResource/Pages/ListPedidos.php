<?php

namespace App\Filament\Resources\PedidoResource\Pages;

use App\Filament\Resources\PedidoResource;
use Filament\Pages\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListPedidos extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = PedidoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return PedidoResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            null => ListRecords\Tab::make('All'),
            'new' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'new')),
            'processing' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'processing')),
            'shipped' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'shipped')),
            'delivered' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
            'cancelled' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
        ];
    }
}
