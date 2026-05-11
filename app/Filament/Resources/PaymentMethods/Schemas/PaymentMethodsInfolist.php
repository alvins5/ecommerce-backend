<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentMethodsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('method_name'),
            ]);
    }
}
