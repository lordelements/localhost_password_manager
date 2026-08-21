<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vault_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('folder_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('website_name');
            $table->string('website_url')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->text('password_encrypted');
            $table->text('notes')->nullable();
            $table->boolean('favorite')->default(false);

            $table->timestamps();

            $table->index('user_id');
            $table->index(['user_id', 'favorite']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vault_entries');
    }
};