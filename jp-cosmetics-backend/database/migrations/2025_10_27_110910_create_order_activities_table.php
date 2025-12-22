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
        Schema::create('order_activity', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            $table->enum('from_status', ['pending', 'confirm', 'dispatched', 'delivered', 'cancelled', 'returned', 'success'])->nullable();
            $table->enum('to_status',   ['pending', 'confirm', 'dispatched', 'delivered', 'cancelled', 'returned', 'success']);

            $table->unsignedBigInteger('created_by')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index(['order_id', 'to_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_activities');
    }
};
