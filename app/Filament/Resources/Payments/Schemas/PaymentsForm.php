<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('payment_method_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('payment_date')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'success' => 'Success', 'failed' => 'Failed', 'refunded' => 'Refunded'])
                    ->required(),
            ]);
    }
}
