<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdutoFornecedorResource\Pages;
use App\Filament\Resources\ProdutoFornecedorResource\RelationManagers;
use App\Models\ProdutoFornecedor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdutoFornecedorResource extends Resource
{
    protected static ?string $model = ProdutoFornecedor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')
                    ->label('Nome')
                    ->required(),
                Forms\Components\TextInput::make('quantidade')
                    ->label('Quantidade')
                    ->numeric()
                    ->rules(['integer', 'min:0'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantidade')
                    ->label('Quantidade')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdutoFornecedors::route('/'),
            'create' => Pages\CreateProdutoFornecedor::route('/create'),
            'edit' => Pages\EditProdutoFornecedor::route('/{record}/edit'),
        ];
    }
}