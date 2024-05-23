<?php

use App\Models\City;
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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name');
            $table->string('short_name')->nullable();
            $table->integer('national_team');
            $table->string('zip_code')->nullable();
            $table->string('address')->nullable();
            $table->string('fundation_at');
            $table->string('end_at')->nullable();
            $table->string('website');
            $table->string('first_color');
            $table->string('seconds_color');
            // foreing key for city
            $table->foreignIdFor(City::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
