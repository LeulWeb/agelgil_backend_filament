<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('profile')->rules(['mimes:jpeg,jpg,png','max:2048'])->nullable(),
                TextInput::make('name')->rules(['required']),
            TextInput::make('email')->rules(['required', 'email', 'unique:users,email'])->placeholder('Enter Email'),
                TextInput::make('role')->nullable(),
                TextInput::make('password')->rules(['min:6', 'max:20', 'confirmed'])->visibleOn('create'),
                TextInput::make('password_confirmation')->rules(['required'])->visibleOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile')->circular()->defaultImageUrl(url('/profile.jpg')),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('role')->toggleable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
