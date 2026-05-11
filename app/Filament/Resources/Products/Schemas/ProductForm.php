<?php

namespace App\Filament\Resources\Products\Schemas;


use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
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
                TextInput::make('stock_quantity')
                    ->required()
                    ->numeric(),
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
                    ->disk('public')
                    ->directory('products')
                    ->required(),
            ]);
    }
}
