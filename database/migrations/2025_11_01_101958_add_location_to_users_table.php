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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('location', [
                'Jakarta - Kemanggisan',
                'Jakarta - Syahdan',
                'Jakarta - Senayan',
                'Tangerang - Alam Sutera',
                'Bekasi',
                'Bandung',
                'Semarang',
                'Malang',
                'Medan'
            ])->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
};
