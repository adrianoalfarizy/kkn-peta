<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aid_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_aid_id')->constrained()->onDelete('cascade');
            $table->foreignId('resident_id')->constrained()->onDelete('cascade');
            $table->enum('status_penerimaan', ['eligible', 'received', 'rejected', 'pending'])->default('eligible');
            $table->date('tanggal_terima')->nullable();
            $table->decimal('jumlah_diterima', 15, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->string('bukti_foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aid_recipients');
    }
};