<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create order_product pivot table
        if (!Schema::hasTable('order_product')) {
            Schema::create('order_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->integer('quantity');
                $table->decimal('price', 10, 2);
                $table->timestamps();
            });
        }

        // Modify existing orders table
        Schema::table('orders', function (Blueprint $table) {
            // Drop existing columns if they exist
            $columns = ['shipping_address', 'phone', 'email'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('orders', 'delivery_location')) {
                $table->string('delivery_location')->nullable();
            }
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Restore original columns
            $table->string('shipping_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Remove new columns
            $table->dropColumn(['delivery_location', 'status']);
        });

        Schema::dropIfExists('order_product');
    }
}; 