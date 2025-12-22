<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * product_attributes
         */
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->string('attribute_name', 100);     // e.g., Size, Color, Weight
            $table->string('attribute_value', 150);    // e.g., L, Red, 500g

            $table->decimal('unit_price', 12, 2)->nullable(); // override base price (optional)
            $table->unsignedInteger('stock')->default(0);

            $table->unsignedInteger('min_order')->default(1);
            $table->unsignedInteger('max_order')->nullable(); // null = no cap

            $table->enum('discount_type', ['fixed', 'percentage'])->nullable();
            $table->decimal('discount_amount', 12, 2)->nullable();

            $table->tinyInteger('status')->default(1)->comment('0=inactive,1=active');
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            $table->index(['product_id', 'status', 'is_default']);
            // Prevent exact duplicate attribute rows for the same product
            $table->unique(['product_id', 'attribute_name', 'attribute_value'], 'uniq_product_attr_name_value');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
