<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Story;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StoryResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                TextInput::make('title')->required(),
                RichEditor::make('story')->rules(['required', 'min:100', 'max:65000']),
                ]),
                
                Group::make()->schema([
                    FileUpload::make('thumbnail')->disk('public')->directory('thumbnail')->nullable(),
                    Select::make('user_id')->relationship('author','name')->required()->visibleOn('create'),
                    Toggle::make('endorsed')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('title'),
                ImageColumn::make('thumbnail'),
                ToggleColumn::make('endorsed')->label('Endorsement'),
                TextColumn::make('author.name')

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
            'index' => Pages\ListStories::route('/'),
            'create' => Pages\CreateStory::route('/create'),
            'edit' => Pages\EditStory::route('/{record}/edit'),
        ];
    }    
}
