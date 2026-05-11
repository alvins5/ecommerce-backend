<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('order_date')
                    ->dateTime(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('total_amount')
                    ->numeric(),
                TextEntry::make('payment_id')
                    ->numeric(),
                TextEntry::make('shipping_address'),
            ]);
    }
}
