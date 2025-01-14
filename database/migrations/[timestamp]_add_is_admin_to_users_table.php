<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false);
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'location')) {
                $table->string('location')->nullable();
            }
        });

        // Set the user with email 'admin@gmail.com' as admin
        DB::table('users')
            ->where('email', 'admin@gmail.com')
            ->update(['is_admin' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'phone', 'location']);
        });
    }
};
