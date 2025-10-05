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
        Schema::table('items', function (Blueprint $table) {
            // Add indexes for better search and filter performance
            $table->index('category_id');
            $table->index('price');
            $table->index('condition');
            $table->index('is_sold');
            $table->index('created_at');
            // Composite index for common filter combinations
            $table->index(['category_id', 'is_sold', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['category_id']);
            $table->dropIndex(['price']);
            $table->dropIndex(['condition']);
            $table->dropIndex(['is_sold']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['category_id', 'is_sold', 'created_at']);
        });
    }
};
