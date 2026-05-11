<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

            TextInput::make('password')
                ->password()
                ->required()
                ->hiddenOn('edit'),

            TextInput::make('address')
                ->maxLength(255),

            TextInput::make('phone')
                ->maxLength(255),

            // Add this for role column
            Select::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'officer' => 'Officer',
                    'customer' => 'Customer',
                ])
                ->required()
                ->default('customer'),

            // Add this for Spatie roles
            Select::make('spatie_roles')
                ->label('Permissions Role')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload(),
        ]);
    }
}