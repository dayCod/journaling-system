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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('offering_letter_id')
                ->nullable()
                ->references('id')
                ->on('offering_letters')
                ->cascadeOnDelete();

            $table->string('code')->unique();
            $table->string('pr_number')->unique();

            $table->date('date');
            $table->date('delivery_date');
            $table->date('expired_date');

            $table->string('supplier_company_name');
            $table->string('attendance');
            $table->text('supplier_company_address');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
