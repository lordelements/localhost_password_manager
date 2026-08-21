<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vault_entry_tag', function (Blueprint $table) {
            $table->foreignId('vault_entry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();

            $table->primary(['vault_entry_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vault_entry_tag');
    }
};