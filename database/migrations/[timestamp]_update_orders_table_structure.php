<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, create the order_product table if it doesn't exist
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

        // Then modify the orders table
        Schema::table('orders', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('orders', 'delivery_location')) {
                $table->string('delivery_location')->after('user_id');
            }
            
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending')->after('delivery_location');
            }

            // Drop old columns if they exist
            if (Schema::hasColumn('orders', 'shipping_address')) {
                $table->dropColumn('shipping_address');
            }
            
            if (Schema::hasColumn('orders', 'phone')) {
                $table->dropColumn('phone');
            }
            
            if (Schema::hasColumn('orders', 'email')) {
                $table->dropColumn('email');
            }
        });
    }

    public function down(): void
    {
        // Reverse the changes
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->dropColumn(['delivery_location', 'status']);
        });

        Schema::dropIfExists('order_product');
    }
}; 