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
            $table->enum('type', ['individual', 'company']); // si es persona o empresa
            $table->string('first_name', 100)->nullable(); // solo para personas
            $table->string('last_name', 100)->nullable(); // solo para personas
            $table->string('company_name', 100)->nullable(); // solo para empresas
            $table->string('document', 20)->unique(); // C.I. o RUC
            $table->string('phone', 20);
            $table->string('email', 100)->unique()->nullable();
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
