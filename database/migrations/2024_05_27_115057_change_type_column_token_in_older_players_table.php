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
        Schema::table('older_players', function (Blueprint $table) {
            $table->longText('token')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('older_players', function (Blueprint $table) {
            // reset to default the token column
            $table->string('token')->nullable()->change();
        });
    }
};
