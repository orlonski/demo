<?php

namespace App\Filament\Resources\Shop\CategoriaResource\RelationManagers;

use App\Filament\Resources\Shop\ProdutoResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProdutosRelationManager extends RelationManager
{
    protected static string $relationship = 'produtos';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return ProdutoResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ProdutoResource::table($table)
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
