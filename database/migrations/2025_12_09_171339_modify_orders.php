<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remove payment_id foreign key and column
            $table->dropColumn('tracking_number');
            
        });
    }

    public function down(): void
    {

    }
};