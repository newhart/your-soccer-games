<?php

use App\Models\Season;
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
        Schema::create('competition_games', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Season::class)->nullable()->constrained();
            $table->unsignedInteger('duration_game');
            $table->date('game_date')->nullable();
            $table->string('game_hour', 10)->nullable();
            $table->unsignedBigInteger('attendace');
            $table->boolean('by_game')->default(false);
            $table->boolean('shootout')->default(false);
            $table->boolean('liver')->default(false);
            $table->unsignedBigInteger('num_match');
            $table->string('type_match', 10)->nullable();
            $table->boolean('shadown_game')->default(false);
            $table->boolean('lineup')->default(true);
            $table->boolean('video')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_games');
    }
};
