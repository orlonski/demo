<?php

namespace App\Filament\Resources\Shop\ProdutoResource\Widgets;

use App\Filament\Resources\Shop\ProdutoResource\Pages\ListProdutos;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProdutoStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProdutos::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Produtos', $this->getPageTableQuery()->count()),
            Stat::make('Produto Inventory', $this->getPageTableQuery()->sum('qty')),
            Stat::make('Average price', number_format($this->getPageTableQuery()->avg('price'), 2)),
        ];
    }
}
