<?php

use App\Models\VariationClub;
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
            $table->foreignIdFor(VariationClub::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_results', function (Blueprint $table) {
            $table->dropColumn('variation_club_id');
        });
    }
};
