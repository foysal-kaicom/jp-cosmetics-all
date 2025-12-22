<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();

            $table->decimal('sub_total_amount', 10, 2);
            $table->decimal('delivery_charge', 10, 2);
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_from_coupon', 10, 2)->nullable();
            $table->decimal('payable_total', 10, 2)->nullable();

            $table->enum('payment_status', ['pending', 'processing', 'cancel', 'failed', 'success', 'refunded']);
            $table->string('transaction_id')->nullable();
            $table->enum('payment_method', ['COD', 'online']);
            $table->string('payment_channel')->nullable();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->longText('additionals')->nullable();

            $table->enum('status', ['pending', 'confirm', 'dispatched', 'delivered', 'cancelled', 'returned', 'success']);
            $table->string('receiver_name')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_area')->nullable();
            $table->string('shipping_location')->nullable();
            $table->foreignId('customer_address_id')->constrained('customer_addresses')->cascadeOnDelete();
            $table->longText('order_note')->nullable();
            $table->longText('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
