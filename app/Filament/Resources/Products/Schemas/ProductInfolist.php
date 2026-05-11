<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('product_name'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('price')
                    ->prefix('Rp'),
                TextEntry::make('category.category_name')
                    ->label('Category'),
                TextEntry::make('brand.brand_name')
                    ->label('Brand'),
                TextEntry::make('stock_quantity')
                    ->label('Stock Quantity'),
                ImageEntry::make('image_url'),
            ]);
    }
}
