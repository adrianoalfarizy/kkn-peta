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
        Schema::table('houses', function (Blueprint $table) {
            $table->index('alamat');
            $table->index(['latitude', 'longitude']);
            $table->index('status');
            $table->index('created_at');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
            $table->index('role');
            $table->index('is_active');
        });
        
        Schema::table('residents', function (Blueprint $table) {
            $table->index('house_id');
            $table->index('nama');
            $table->index('status_ekonomi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropIndex(['alamat']);
            $table->dropIndex(['latitude', 'longitude']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['role']);
            $table->dropIndex(['is_active']);
        });
        
        Schema::table('residents', function (Blueprint $table) {
            $table->dropIndex(['house_id']);
            $table->dropIndex(['nama']);
            $table->dropIndex(['status_ekonomi']);
        });
    }
};
