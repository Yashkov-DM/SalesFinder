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
        Schema::create('group_calculate_prices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('conditionId')->nullable()->constrained('conditions')->nullOnDelete();
            $table->integer('conditionValueFirst');
            $table->integer('conditionValueSecond')->nullable();
            $table->foreignId('expressionId')->nullable()->constrained('expressions')->nullOnDelete();
            $table->integer('expressionValue');
            $table->string('resultFieldName');
            $table->integer('quantityProduct')->nullable();
            $table->boolean('active')->default(true);
            $table->dateTime('lastStartTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_calculate_prices');
    }
};
