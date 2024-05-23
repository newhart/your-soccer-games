<?php

use App\Models\Competition;
use App\Models\CompetitionType;
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
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('competition_season_name');
            $table->date('start_at');
            $table->date('end_at');
            $table->integer('priority');
            $table->integer('division_number');
            $table->string('season');
            // foreing key 
            $table->foreignIdFor(Competition::class)->constrained();
            $table->foreignIdFor(CompetitionType::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
