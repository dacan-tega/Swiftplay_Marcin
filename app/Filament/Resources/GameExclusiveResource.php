<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameExclusiveResource\Pages;
use App\Filament\Resources\GameExclusiveResource\RelationManagers;
use App\Models\Category;
use App\Models\GameExclusive;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GameExclusiveResource extends Resource
{
    protected static ?string $model = GameExclusive::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationLabel = 'Platform Games';

    protected static ?string $modelLabel = 'Platform Games';

    protected static ?string $navigationGroup = 'My Game';

    protected static ?string $slug = 'my-games-exclusivos';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = -1;

    /**
     * @return string|null
     */
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count(); // TODO: Change the autogenerated stub
    }

    /**
     * @return string|array|null
     */
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 5 ? 'success' : 'warning'; // TODO: Change the autogenerated stub
    }


    /**
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Games')
                    ->description(__('admin.Registering_game'))
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label(__('admin.Category'))
                            ->placeholder(__('admin.Select_category'))
                            ->relationship(name: 'category', titleAttribute: 'name')
                            ->options(
                                fn($get) => Category::query()
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->columnSpanFull(),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('admin.Game_name'))
                                    ->placeholder(__('admin.Enter_name_game'))
                                    ->required()
                                    ->maxLength(191),
                                Forms\Components\TextInput::make('uuid')
                                    ->label('UUID')
                                    ->placeholder(__('admin.Enter_UUID'))
                                    ->required()
                                    ->maxLength(191),
                            ])->columns(2),

                        RichEditor::make('description')
                            ->columnSpanFull(),
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\FileUpload::make('cover')
                                    ->label(__('admin.Cover'))
                                    ->placeholder(__('admin.Load_cover'))
                                    ->image()
                                    ->required(),
                                Forms\Components\FileUpload::make('icon')
                                    ->label(__('admin.Icon'))
                                    ->placeholder(__('admin.Load_icon'))
                                    ->image()
                                    ->required(),
                            ])->columns(2),
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('winLength')
                                    ->required()
                                    ->numeric()
                                    ->default(3),
                                Forms\Components\TextInput::make('loseLength')
                                    ->required()
                                    ->numeric()
                                    ->default(20),
                                Forms\Components\TextInput::make('influencer_winLength')
                                    ->required()
                                    ->numeric()
                                    ->default(20),
                                Forms\Components\TextInput::make('influencer_loseLength')
                                    ->required()
                                    ->numeric()
                                    ->default(1),
                            ])->columns(4),
                        Forms\Components\Toggle::make('active')
                            ->label(__('admin.Activate_Game'))
                            ->default(true)
                            ->required()
                            ->columnSpanFull(),
                    ])
            ]);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.Name'))
                    ->searchable(),

                Tables\Columns\ImageColumn::make('cover')
                    ->label(__('admin.Cover')),
                Tables\Columns\ImageColumn::make('icon')
                    ->label(__('admin.Icon')),

                Tables\Columns\TextColumn::make('winLength')
                    //->toggleable(isToggledHiddenByDefault: true)
                        ->label(__('admin.Victory'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loseLength')
                    //->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('admin.loss'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('influencer_winLength')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('influencer_loseLength')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->label(__('admin.Active')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions(env('APP_DEMO') ? [] :[
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListGameExclusives::route('/'),
            'create' => Pages\CreateGameExclusive::route('/create'),
            'edit' => Pages\EditGameExclusive::route('/{record}/edit'),
        ];
    }
}
