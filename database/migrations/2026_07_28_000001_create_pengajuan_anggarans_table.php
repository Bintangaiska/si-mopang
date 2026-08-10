<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_anggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('unit_kerja');
            $table->date('tanggal_pengajuan');
            $table->decimal('jumlah', 15, 2);
            $table->string('file_rka')->nullable();
            $table->string('file_perwabku')->nullable();
            $table->string('status')->default('Diproses');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_anggarans');
    }
};
