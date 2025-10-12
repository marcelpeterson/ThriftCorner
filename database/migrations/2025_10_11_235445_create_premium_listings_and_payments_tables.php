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
        // Premium Listings table
        Schema::create('premium_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('package_type', ['basic', 'featured', 'spotlight'])->default('basic');
            $table->decimal('price', 10, 2);
            $table->integer('duration_days');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->json('features')->nullable(); // Store feature details
            $table->timestamps();
        });

        // Payments table
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('premium_listing_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_id')->unique();
            $table->string('transaction_id')->nullable();
            $table->enum('payment_type', ['premium_listing'])->default('premium_listing');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('midtrans_response')->nullable();
            $table->text('snap_token')->nullable();
            $table->timestamps();
        });

        // Add premium fields to items table
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('is_premium')->default(false)->after('is_sold');
            $table->timestamp('premium_until')->nullable()->after('is_premium');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['is_premium', 'premium_until']);
        });
        
        Schema::dropIfExists('payments');
        Schema::dropIfExists('premium_listings');
    }
};
