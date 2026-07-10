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
        // even if something broken we can prevent crash
        // stop early
        if (Schema::hasTable('tasks')) {
            return;
        }
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->boolean('completed')->default(false)->index('completed_index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
