<?php

use App\Models\Club;
use App\Models\CompetitionGame;
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
        Schema::create('club_competition_game', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('goals_for');
            $table->unsignedInteger('goals_against');
            $table->boolean('home')->default(false);
            $table->unsignedInteger('halftime1');
            $table->unsignedInteger('halftime2');
            //foreing  key 
            $table->foreignIdFor(Club::class);
            $table->foreignIdFor(CompetitionGame::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_competition_game');
    }
};
