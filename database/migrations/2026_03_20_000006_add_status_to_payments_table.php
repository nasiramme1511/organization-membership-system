<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'failed'])->default('pending')->after('amount');
            $table->string('method')->default('cash')->after('status');
            $table->string('transaction_ref')->nullable()->after('method');
            $table->timestamp('paid_at')->nullable()->after('transaction_ref');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['status', 'method', 'transaction_ref', 'paid_at']);
        });
    }
};
