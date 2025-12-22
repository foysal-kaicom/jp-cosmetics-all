<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_attribute_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('added_at')->useCurrent();
            $table->unique(['customer_id', 'product_id', 'product_attribute_id'], 'unique_wishlist_item');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
};
