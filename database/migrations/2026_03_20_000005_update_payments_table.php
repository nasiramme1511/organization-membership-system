<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
            $table->string('method')->default('cash')->after('amount');
            $table->string('transaction_ref')->nullable()->after('status');
            $table->timestamp('paid_at')->nullable()->after('transaction_ref');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['subscription_id', 'method', 'transaction_ref', 'paid_at']);
        });
    }
};
