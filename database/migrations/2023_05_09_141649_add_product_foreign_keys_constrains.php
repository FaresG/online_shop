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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignUuid('user_id')->constrained();
            $table->foreignId('product_category_id')->constrained();
            $table->foreignId('product_inventory_id')->constrained();
            $table->foreignId('discount_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('product_category_id');
            $table->dropConstrainedForeignId('product_inventory_id');
            $table->dropConstrainedForeignId('discount_id');
        });
    }
};
