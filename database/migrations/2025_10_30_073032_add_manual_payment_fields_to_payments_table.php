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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('proof_of_payment')->nullable()->after('snap_token');
            $table->string('bank_name')->nullable()->after('proof_of_payment');
            $table->string('account_name')->nullable()->after('bank_name');
            $table->string('account_number')->nullable()->after('account_name');
            $table->timestamp('confirmed_at')->nullable()->after('paid_at');
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('confirmed_at');
            $table->text('admin_notes')->nullable()->after('confirmed_by');
            
            // Add foreign key for admin who confirmed the payment
            $table->foreign('confirmed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn([
                'proof_of_payment',
                'bank_name',
                'account_name', 
                'account_number',
                'confirmed_at',
                'confirmed_by',
                'admin_notes'
            ]);
        });
    }
};
