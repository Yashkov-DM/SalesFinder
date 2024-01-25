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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storeId')->nullable()->constrained('stores')->nullOnDelete();
            $table->foreignId('groupCalcPriseId')->nullable()->constrained('group_calculate_prices')->nullOnDelete();
            $table->integer('nmId');
            $table->string('supplierArticle');
            $table->string('warehouseName');
            $table->string('category');
            $table->string('subject');
            $table->integer('quantityFull');
            $table->integer('price');
            $table->integer('offerPrice')->nullable();
            $table->integer('discount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
