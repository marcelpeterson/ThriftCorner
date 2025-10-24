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
        Schema::table('support_contacts', function (Blueprint $table) {
            // Change the enum to include delete_listing
            $table->enum('type', ['report_suspicious', 'feedback', 'delete_listing'])->default('feedback')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_contacts', function (Blueprint $table) {
            // Revert to original enum values
            $table->enum('type', ['report_suspicious', 'feedback'])->default('feedback')->change();
        });
    }
};