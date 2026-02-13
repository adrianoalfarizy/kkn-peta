<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->index('nik');
            $table->index('nama');
            $table->index('status_ekonomi');
        });

        Schema::table('houses', function (Blueprint $table) {
            $table->index('alamat');
            $table->index('status');
        });

        Schema::table('debts', function (Blueprint $table) {
            $table->index('status');
            $table->index('jenis_subsidi');
            $table->index('jatuh_tempo');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->index('status');
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropIndex(['nik']);
            $table->dropIndex(['nama']);
            $table->dropIndex(['status_ekonomi']);
        });

        Schema::table('houses', function (Blueprint $table) {
            $table->dropIndex(['alamat']);
            $table->dropIndex(['status']);
        });

        Schema::table('debts', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['jenis_subsidi']);
            $table->dropIndex(['jatuh_tempo']);
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['kategori']);
        });
    }
};
