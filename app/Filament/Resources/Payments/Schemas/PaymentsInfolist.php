<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('payment_method_id')
                    ->numeric(),
                TextEntry::make('payment_date')
                    ->dateTime(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
            ]);
    }
}
