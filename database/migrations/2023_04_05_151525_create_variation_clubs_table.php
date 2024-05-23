<?php

use App\Models\Club;
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
        Schema::create('variation_clubs', function (Blueprint $table) {
            $table->id();
            $table->string('variant_name')->nullable();
            $table->string('short_variant_name')->nullable();
            $table->foreignIdFor(Club::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the <migrations class=""></migrations>
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_clubs');
    }
};
