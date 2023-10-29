<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $slug = 'clientes';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Clientes';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 1;

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
                                ->maxValue(11),
                            Forms\Components\TextInput::make('celular')
                                ->label('Telefone')
                                ->required()
                                ->maxValue(13),
                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->unique(ignoreRecord: true),
                            Forms\Components\DatePicker::make('data_nascimento')
                                ->label('Data Nascimento')
                                ->maxDate('today'),
                        ]),
                    Wizard\Step::make('Endereço')
                        ->schema([
                            Forms\Components\TextInput::make('endereco'),
                            Forms\Components\TextInput::make('numero'),
                            Forms\Components\TextInput::make('complemento'),
                            Forms\Components\TextInput::make('cep'),
                            Forms\Components\TextInput::make('bairro'),
                            Forms\Components\TextInput::make('cidade'),
                            Forms\Components\TextInput::make('uf')
                                ->label('UF')
                        ]),
                    Wizard\Step::make('Informações Adicionais')
                        ->schema([
                            Forms\Components\Textarea::make('observacao'),
                        ])
                        ->columns(1)
                ])
                    ->columns(2)
                    ->columnSpan(['lg' => fn(?Cliente $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Criado em')
                            ->content(fn(Cliente $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Última modificação em')
                            ->content(fn(Cliente $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn(?Cliente $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->sortable(),
                Tables\Columns\TextColumn::make('celular')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        Notification::make()
                            ->title('Não seja atrevido, deixe alguns registros!')
                            ->warning()
                            ->send();
                    }),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('addresses')->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}