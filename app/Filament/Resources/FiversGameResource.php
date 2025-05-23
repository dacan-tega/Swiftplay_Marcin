<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiversGameResource\Pages;
use App\Filament\Resources\FiversGameResource\RelationManagers;
use App\Models\Category;
use App\Models\FiversGame;
use App\Models\FiversProvider;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FiversGameResource extends Resource
{
    protected static ?string $model = FiversGame::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationLabel = 'Fivers Games';

    protected static ?string $modelLabel = 'Fivers Games';

    protected static ?string $navigationGroup = 'Fivers';

    protected static ?string $slug = 'fivers-jogos';

    protected static ?int $navigationSort = 0;

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

                Forms\Components\Section::make('Provedores/Categorias')
                    ->description(__('admin.Select_provider_category'))
                    ->schema([
                        Forms\Components\Select::make('casino_category_id')
                            ->label(__('admin.Category'))
                            ->placeholder(__('admin.Select_category'))
                            ->relationship(name: 'category', titleAttribute: 'name')
                            ->options(
                                fn($get) => Category::query()
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live(),
                        Forms\Components\Select::make('fivers_provider_id')
                            ->label(__('admin.Provider'))
                            ->placeholder(__('admin.Select_provider'))
                            ->relationship(name: 'provider', titleAttribute: 'name')
                            ->options(
                                fn($get) => FiversProvider::query()
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live(),
                    ])->columns(2),

                Forms\Components\Section::make('Provedores')
                    ->description(__('admin.Select_provider'))
                    ->schema([
                        Forms\Components\TextInput::make('game_code')
                            ->label(__('admin.Game_Code'))
                            ->placeholder(__('admin.Enter_code'))
                            ->maxLength(50),
                        Forms\Components\TextInput::make('game_name')
                            ->label(__('admin.Game_name'))
                            ->placeholder(__('admin.Enter_name_game'))
                            ->maxLength(50),
                        Forms\Components\Toggle::make('status')->required(),
                        Forms\Components\FileUpload::make('banner')
                            ->label(__('admin.Image'))
                            ->placeholder(__('admin.Upload_image'))
                            ->image()
                            ->columnSpanFull()
                            ->required(),
                    ])->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('banner'),
                Tables\Columns\TextColumn::make('provider.name')
                    ->label(__('admin.Provider'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('admin.Category'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('game_code')
                    ->label(__('admin.Game_Code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('game_name')
                    ->label(__('admin.Game_name'))
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Category')
                    ->relationship('category', 'name')
                    ->label(__('admin.Select_category'))
                    ->indicator(__('admin.Category')),
                Tables\Filters\SelectFilter::make('Provedor')
                    ->relationship('provider', 'name')
                    ->label(__('admin.Select_provider'))
                    ->indicator(__('admin.Provider')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListFiversGames::route('/'),
            'create' => Pages\CreateFiversGame::route('/create'),
            'edit' => Pages\EditFiversGame::route('/{record}/edit'),
        ];
    }
}
