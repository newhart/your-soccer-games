<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('matchs')->nullable();
            $table->string('pays')->nullable();
            $table->string('format')->nullable();
            $table->string('n_disque');
            $table->double('price')->nullable();
            $table->string('short_description')->nullable();
            $table->string('saison', 20);
            $table->string('genre');
            $table->string('residence');
            $table->string('visitor');
            $table->string('journey')->nullable();
            $table->date('date_match')->nullable();
            $table->string('result')->nullable();
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('image');
            $table->boolean('is_right_now');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
