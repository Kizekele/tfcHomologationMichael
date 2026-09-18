<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agent', function (Blueprint $table) {
            $table->string('matricule_agent', 20)->primary();
            $table->string('nom_agent', 100);
            $table->string('fonction_agent', 100)->nullable();
            $table->string('telephone_agent', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent');
    }
};