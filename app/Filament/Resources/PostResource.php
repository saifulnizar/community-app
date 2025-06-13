<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\TagsInput;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Posts';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->label('Author')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
                
            TextInput::make('title')
                ->required()
                ->maxLength(255),

            Textarea::make('content')
                ->required(),

            Toggle::make('is_approved')
                ->label('Approved'),

            Select::make('tags')
                ->label('Tags')
                ->multiple()
                ->preload()
                ->relationship('tags', 'name')
                ->createOptionForm([
                    TextInput::make('name')
                        ->label('Tag Name')
                        ->required()
                        ->maxLength(50),
                ])
                ->createOptionUsing(function (array $data) {
                    $incoming = Str::slug($data['name']);

                    // Cari tag yang sudah ada berdasarkan slug dari name
                    $existing = Tag::all()->first(function ($tag) use ($incoming) {
                        return Str::slug($tag->name) === $incoming;
                    });

                    return $existing ?: Tag::create(['name' => $data['name']]);
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Author')
                ->sortable()
                ->searchable(),

            Tables\Columns\IconColumn::make('is_approved')
                ->label('Approved')
                ->boolean(),

            Tables\Columns\TextColumn::make('tags.name')
                ->label('Tags')
                ->badge()
                ->separator(', ')
                ->limit(3),
        ])
        ->filters([
            Tables\Filters\TernaryFilter::make('is_approved')
                ->label('Approval Status')
                ->trueLabel('Approved')
                ->falseLabel('Pending'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
