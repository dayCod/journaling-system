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
        Schema::create('vendor_items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->double('price')->default(0);
            $table->text('note')->nullable();
            $table->string('code')->nullable();

            $table->foreignId('vendor_id')
                ->references('id')
                ->on('vendors')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_items');
    }
};
