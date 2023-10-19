<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarcaResource\RelationManagers\ProdutosRelationManager;
use App\Filament\Resources\ProdutoResource\Pages;
use App\Filament\Resources\ProdutoResource\RelationManagers;
use App\Filament\Resources\ProdutoResource\Widgets\ProdutoStats;
use App\Models\Produto;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProdutoResource extends Resource
{
    protected static ?string $model = Produto::class;

    protected static ?string $slug = 'produtos';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Produtos';

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationLabel = 'Produtos';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->required(),
                                Forms\Components\MarkdownEditor::make('description')
                                    ->label('Descrição')
                                    ->columnSpan('full'),
                            ])
                            ->columns(1),

                        Forms\Components\Section::make('Imagens')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('produto-images')
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->disableLabel(),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('Preços')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Preço')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                                Forms\Components\TextInput::make('custo')
                                    ->label('Custo')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make('Inventário')
                            ->schema([
                                Forms\Components\TextInput::make('barcode')
                                    ->label('Código de barras')
                                    ->unique(Produto::class, 'barcode', ignoreRecord: true)
                                    ->required(),

                                Forms\Components\TextInput::make('qty')
                                    ->label('Quantidade')
                                    ->numeric()
                                    ->rules(['integer', 'min:0'])
                                    ->required(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Toggle::make('is_visible')
                                    ->label('Visível')
                                    ->helperText('Este produto ficará oculto em todos os canais de vendas.')
                                    ->default(true),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label('Disponibilidade')
                                    ->default(now())
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Associações')
                            ->schema([
                                Forms\Components\Select::make('marca_id')
                                    ->relationship('marca', 'name')
                                    ->searchable()
                                    ->hiddenOn(ProdutosRelationManager::class),

                                Forms\Components\Select::make('categorias')
                                    ->relationship('categorias', 'name')
                                    ->multiple()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('produto-image')
                    ->label('Imagem')
                    ->collection('produto-images'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('marca.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visibilidade')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('qty')
                    ->label('Quantidade')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Data de criação')
                    ->date()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('marca')
                    ->relationship('marca', 'name')
                    ->preload()
                    ->multiple()
                    ->searchable(),

                Tables\Filters\TernaryFilter::make('is_visible')
                    ->label('Visibilidade')
                    ->boolean()
                    ->trueLabel('Apenas visível')
                    ->falseLabel('Apenas oculto')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        Notification::make()
                            ->title('Não seja atrevido, deixe pelo menos um registro!')
                            ->warning()
                            ->send();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getWidgets(): array
    {
        return [
            ProdutoStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdutos::route('/'),
            'create' => Pages\CreateProduto::route('/create'),
            'edit' => Pages\EditProduto::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sku', 'marca.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Produto $record */

        return [
            'Marca' => optional($record->marca)->name,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['marca']);
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::$model::whereColumn('qty', '<', 'security_stock')->count();
    // }
}