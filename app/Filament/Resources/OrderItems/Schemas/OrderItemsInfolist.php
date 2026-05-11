<?php

namespace App\Filament\Resources\OrderItems\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderItemsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('order_id')
                    ->numeric(),
                TextEntry::make('product_id')
                    ->numeric(),
                TextEntry::make('quantity')
                    ->numeric(),
            ]);
    }
}
