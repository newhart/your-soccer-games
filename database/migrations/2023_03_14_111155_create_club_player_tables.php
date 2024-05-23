<?php

use App\Models\Club;
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
        Schema::create('club_player', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Club::class)->constrained();
            $table->foreignIdFor(Player::class)->constrained();
            $table->date('arrival_at')->nullable();
            $table->date('leaving_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_player');
    }
};
