<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rencana_anggarans', function (Blueprint $table) {
            $table->id();
            $table->string('satker');
            $table->string('item');
            $table->decimal('pagu', 15, 0)->default(0);
            $table->decimal('jan', 15, 0)->default(0);
            $table->decimal('feb', 15, 0)->default(0);
            $table->decimal('mar', 15, 0)->default(0);
            $table->decimal('apr', 15, 0)->default(0);
            $table->decimal('mei', 15, 0)->default(0);
            $table->decimal('jun', 15, 0)->default(0);
            $table->decimal('jul', 15, 0)->default(0);
            $table->decimal('agu', 15, 0)->default(0);
            $table->decimal('sep', 15, 0)->default(0);
            $table->decimal('okt', 15, 0)->default(0);
            $table->decimal('nov', 15, 0)->default(0);
            $table->decimal('des', 15, 0)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_anggarans');
    }
};
