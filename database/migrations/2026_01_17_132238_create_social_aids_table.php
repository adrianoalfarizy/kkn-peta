<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_aids', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bantuan');
            $table->enum('jenis_bantuan', ['pkh', 'bpnt', 'blt', 'sembako', 'tunai', 'lainnya']);
            $table->text('deskripsi')->nullable();
            $table->decimal('nominal', 15, 2)->nullable();
            $table->date('tanggal_distribusi');
            $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned');
            $table->integer('target_penerima')->default(0);
            $table->integer('realisasi_penerima')->default(0);
            $table->string('sumber_dana')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_aids');
    }
};