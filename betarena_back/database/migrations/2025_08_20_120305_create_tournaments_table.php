<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->string('platform');
            $table->integer('max_participants');
            $table->decimal('entry_fee', 12, 2)->default(0);
            $table->string('match_format')->nullable();
            $table->enum('type', ['elimination', 'round_robin', 'other'])->default('elimination');
            $table->boolean('is_private')->default(false);
            $table->dateTime('start_date')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['planned', 'open', 'in_progress', 'finished', 'cancelled'])->default('planned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
