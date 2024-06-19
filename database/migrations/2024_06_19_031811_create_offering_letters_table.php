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
        Schema::create('offering_letters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('office_id')
                ->references('id')
                ->on('offices')
                ->cascadeOnDelete();

            $table->string('code')->unique();
            $table->string('attendance');
            $table->string('sales_manager');
            $table->string('sales_manager_phone');
            $table->text('note');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offering_letters');
    }
};
