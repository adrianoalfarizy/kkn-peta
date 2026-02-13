<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->enum('status_keluarga', ['kepala', 'istri', 'anak', 'orang_tua', 'lainnya']);
            $table->enum('status_kawin', ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati']);
            $table->string('agama');
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('status_ekonomi', ['miskin', 'tidak_miskin', 'rentan_miskin'])->default('tidak_miskin');
            $table->boolean('penerima_pkh')->default(false);
            $table->boolean('penerima_bpnt')->default(false);
            $table->boolean('penerima_blt')->default(false);
            $table->string('no_hp')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};