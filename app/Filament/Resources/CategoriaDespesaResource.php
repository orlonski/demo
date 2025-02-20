<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriaDespesaResource\Pages;
use App\Models\CategoriaDespesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoriaDespesaResource extends Resource
{
    protected static ?string $model = CategoriaDespesa::class;

    protected static ?string $navigationGroup = 'Despesas';

    protected static ?string $modelLabel = 'Categoria';

    protected static ?string $pluralModelLabel = 'Categorias';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListCategoriaDespesas::route('/'),
            'create' => Pages\CreateCategoriaDespesa::route('/create'),
            'edit' => Pages\EditCategoriaDespesa::route('/{record}/edit'),
        ];
    }
}
