<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentMethodsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('method_name')
                    ->required(),
            ]);
    }
}
