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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('industry')->nullable();
            $table->string('company_size')->nullable();
            $table->decimal('revenue', 15, 2)->nullable();
            $table->decimal('profit_margin_eur', 15, 2)->nullable();
            $table->decimal('margin_percent', 5, 2)->nullable();
            $table->decimal('effort_hours', 8, 2)->nullable();
            $table->integer('chemistry_score')->nullable(); // 1-5
            $table->integer('growth_score')->nullable(); // 1-5
            $table->decimal('repeat_rate', 5, 2)->nullable(); // Percentage
            $table->integer('recommendations')->nullable();
            $table->integer('payment_willingness')->nullable(); // 1-5
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
