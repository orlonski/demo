<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FornecedorResource\Pages;
use App\Models\Fornecedor;
use App\Models\ProdutoFornecedor;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FornecedorResource extends Resource
{
    protected static ?string $model = Fornecedor::class;

    protected static ?string $slug = 'fornecedores';

    protected static ?string $modelLabel = 'Fornecedor';

    protected static ?string $pluralModelLabel = 'Fornecedores';

    protected static ?string $navigationGroup = 'Fornecedores';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Dados básicos')
                        ->schema([
                            Forms\Components\TextInput::make('nome')
                                ->maxValue(50)
                                ->required(),
                            Forms\Components\TextInput::make('documento')
                                ->label('CPF/CNPJ')
                                ->maxValue(18),
                            Forms\Components\TextInput::make('celular')
                                ->label('Telefone')
                                ->maxValue(13),
                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->unique(ignoreRecord: true),
                        ]),
                    Wizard\Step::make('Produtos/Serviços')
                        ->schema(static::getFormItems())
                        ->columns(1),
                    Wizard\Step::make('Endereço')
                        ->schema([
                            Forms\Components\TextInput::make('endereco'),
                            Forms\Components\TextInput::make('numero'),
                            Forms\Components\TextInput::make('complemento'),
                            Forms\Components\TextInput::make('cep'),
                            Forms\Components\TextInput::make('bairro'),
                            Forms\Components\TextInput::make('cidade'),
                            Forms\Components\TextInput::make('uf'),
                        ]),
                ])
                    ->columns(2)
                    ->columnSpan(['lg' => fn (?Fornecedor $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Criado em')
                            ->content(fn (Fornecedor $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Última modificação em')
                            ->content(fn (Fornecedor $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Fornecedor $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
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
            'index' => Pages\ListFornecedors::route('/'),
            'create' => Pages\CreateFornecedor::route('/create'),
            'edit' => Pages\EditFornecedor::route('/{record}/edit'),
        ];
    }

    public static function getFormItems(string $section = null): array
    {
        return [
            Repeater::make('itens')
                ->relationship()
                ->schema([
                    Forms\Components\Select::make('produto_id')
                        ->label('Produto')
                        ->options(ProdutoFornecedor::query()->pluck('descricao', 'id'))
                        ->required()
                        ->reactive()
                        ->columnSpan([
                            'md' => 8,
                        ])
                        ->searchable(),
                    Forms\Components\TextInput::make('valor')
                        ->label('Quantidade')
                        ->numeric()
                        ->default(1)
                        ->columnSpan([
                            'md' => 2,
                        ])
                        ->required(),
                ])
                ->required()
                ->columns([
                    'md' => 10,
                ]),
        ];

    }
}
