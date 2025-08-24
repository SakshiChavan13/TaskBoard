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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_list_id')->constrained('board_lists')->cascadeOnDelete();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->unsignedInteger('position')->default(0); // 0..N top-to-bottom
            $table->date('due_date')->nullable();
            $table->timestamps();
            $table->index(['board_list_id']);
            $table->unique(['board_list_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
