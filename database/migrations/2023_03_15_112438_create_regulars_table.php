<?php

use App\Models\Player;
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
        Schema::create('regulars', function (Blueprint $table) {
            $table->id();
            $table->integer('tactical_position');
            $table->boolean('valid');

            // foreign id 
            $table->foreignIdFor(Season::class)->constrained();
            $table->foreignIdFor(Player::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regulars');
    }
};
