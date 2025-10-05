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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buyer_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('seller_token')->unique();
            $table->string('buyer_token')->unique();
            $table->boolean('seller_confirmed')->default(false);
            $table->boolean('buyer_confirmed')->default(false);
            $table->timestamp('seller_confirmed_at')->nullable();
            $table->timestamp('buyer_confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        // Add sold status to items table
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('is_sold')->default(false)->after('condition');
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('set null')->after('is_sold');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropColumn(['is_sold', 'transaction_id']);
        });
        
        Schema::dropIfExists('transactions');
    }
};
