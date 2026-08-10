<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('satker_id')->nullable()->after('role')->constrained()->nullOnDelete();
            $table->foreignId('ur_id')->nullable()->after('satker_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['satker_id']);
            $table->dropForeign(['ur_id']);
            $table->dropColumn(['satker_id', 'ur_id']);
        });
    }
};