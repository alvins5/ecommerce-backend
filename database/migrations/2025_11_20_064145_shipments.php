<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        schema::create('shipments', function (blueprint $table){
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');
            $table->string('tracking_number')->unique();
            $table->string('courier');
            $table->date('shipped_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
