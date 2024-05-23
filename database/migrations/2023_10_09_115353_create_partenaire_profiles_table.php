<?php

use App\Models\User;
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
        Schema::create('partenaire_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('presentation');
            $table->string('format');
            $table->string('livraison');
            $table->unsignedInteger('total_number');
            $table->string('coverture');
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partenaire_profiles');
    }
};
