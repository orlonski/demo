<?php

namespace App\Filament\Resources\Shop\PedidoResource\Widgets;

use App\Filament\Resources\Shop\PedidoResource\Pages\ListPedidos;
use App\Models\Shop\Pedido;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PedidoStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListPedidos::class;
    }

    protected function getStats(): array
    {
        $pedidoData = Trend::model(Pedido::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Pedidos', $this->getPageTableQuery()->count())
                ->chart(
                    $pedidoData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Stat::make('Pedidos em aberto', $this->getPageTableQuery()->whereIn('status', ['open', 'processing'])->count()),
            Stat::make('Preço médio', number_format($this->getPageTableQuery()->avg('total_price'), 2)),
        ];
    }
}
