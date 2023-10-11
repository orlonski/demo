<?php

namespace App\Filament\Resources\Shop\PedidoResource\Pages;

use App\Filament\Resources\Shop\PedidoResource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class CreatePedido extends CreateRecord
{
    use HasWizard;

    protected static string $resource = PedidoResource::class;

    protected function afterCreate(): void
    {
        $pedido = $this->record;

        Notification::make()
            ->title('Novo pedido')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$pedido->cliente->name} encomendado {$pedido->items->count()} produtos.**")
            ->actions([
                Action::make('View')
                    ->url(PedidoResource::getUrl('edit', ['record' => $pedido])),
            ])
            ->sendToDatabase(auth()->user());
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Pedido Details')
                ->schema([
                    Section::make()->schema(PedidoResource::getFormSchema())->columns(),
                ]),

            Step::make('Pedido Items')
                ->schema([
                    Section::make()->schema(PedidoResource::getFormSchema('items')),
                ]),
        ];
    }
}
