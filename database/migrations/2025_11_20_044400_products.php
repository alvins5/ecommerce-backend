<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        schema::create('products', function (blueprint $table){
            $table->id();
            $table->string('product_name');
            $table->text('description');
            $table->decimal('price', 20, 2);
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            $table->foreignId('brand_id')
                  ->constrained('brands')
                  ->onDelete('cascade');
            $table->string('image_url');
            $table->unsignedInteger('stock_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
