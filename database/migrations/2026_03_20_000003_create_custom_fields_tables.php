<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['text', 'number', 'date', 'select', 'checkbox']);
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });

        Schema::create('member_custom_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('custom_field_id')->constrained()->onDelete('cascade');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['member_id', 'custom_field_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_custom_values');
        Schema::dropIfExists('custom_fields');
    }
};
