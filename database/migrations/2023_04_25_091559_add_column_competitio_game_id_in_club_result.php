<?php

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
        Schema::table('club_results', function (Blueprint $table) {
            $table->foreignIdFor(CompetitionGame::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_results', function (Blueprint $table) {
            $table->dropColumn('competiton_game_id');
        });
    }
};
