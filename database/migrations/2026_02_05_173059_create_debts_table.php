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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_subsidi', ['pupuk', 'bibit', 'alat_pertanian', 'lainnya']);
            $table->string('deskripsi');
            $table->decimal('jumlah_utang', 15, 2);
            $table->decimal('jumlah_dibayar', 15, 2)->default(0);
            $table->enum('status', ['belum_lunas', 'lunas', 'menunggak'])->default('belum_lunas');
            $table->date('tanggal_utang');
            $table->date('jatuh_tempo')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->index(['resident_id', 'status']);
            $table->index('tanggal_utang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
