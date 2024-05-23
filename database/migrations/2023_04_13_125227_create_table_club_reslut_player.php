<?php

use App\Models\Club;
use App\Models\ClubResult;
use App\Models\Player;
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
        Schema::create('club_result_player', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class)->nullable()->constrained();
            $table->foreignIdFor(ClubResult::class)->nullable()->constrained();
            $table->boolean('substitude')->default(false);
            $table->unsignedInteger('player_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_result_player');
    }
};
