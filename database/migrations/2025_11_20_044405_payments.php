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
        schema::create('payments', function (blueprint $table){
            $table->id();
            $table->foreignId('payment_method_id')
                  ->constrained('payment_methods')
                  ->onDelete('cascade');
            $table->dateTime('payment_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status',['pending','success','failed','refunded']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
