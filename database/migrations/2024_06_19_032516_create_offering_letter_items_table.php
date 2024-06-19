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
        Schema::create('offering_letter_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('offering_letter_id')
                ->references('id')
                ->on('offering_letters')
                ->cascadeOnDelete();

            $table->foreignId('vendor_item_id')
                ->references('id')
                ->on('vendor_items')
                ->cascadeOnDelete();

            $table->unsignedInteger('quantity');

            $table->double('retail_price_per_item');
            $table->double('total_price_per_item');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offering_letter_items');
    }
};
