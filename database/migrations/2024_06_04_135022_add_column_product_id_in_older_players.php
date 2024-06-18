<?php

use App\Models\Product;
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
            $table->foreignIdFor(Product::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('older_players', function (Blueprint $table) {
            // remove the foreign key
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};
