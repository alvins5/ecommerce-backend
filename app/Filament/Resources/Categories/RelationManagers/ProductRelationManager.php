<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;


class ProductRelationManager extends RelationManager
{
    protected static string $relationship = 'Products';

    public function form(schema $schema): schema
    {
        return $schema
            ->components([
                TextInput::make('product_name')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                Select::make('category_id')
                    ->relationship('category', 'category_name')
                    ->label('Category')
                    ->required(),
                Select::make('brand_id')
                    ->relationship('brand', 'brand_name')
                    ->label('Brand')
                    ->required(),
                FileUpload::make('image_url')
                    ->image()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->searchable(),
                TextColumn::make('price')
                    ->money('idr')
                    ->sortable(),
                TextColumn::make('category.category_name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('brand.brand_name')
                    ->label('Brand')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image_url'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
