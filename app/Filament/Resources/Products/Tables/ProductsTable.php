<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->searchable(),
                TextColumn::make('stock_quantity')
                    ->sortable(),
                TextColumn::make('price')
                    ->prefix('IDR')
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
