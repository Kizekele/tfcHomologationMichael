<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('composer', function (Blueprint $table) {
            $table->string('matricule_inspecteur', 20);
            $table->unsignedBigInteger('id_equipe');
            $table->string('role', 30);
            $table->primary(['matricule_inspecteur', 'id_equipe']);
            $table->foreign('matricule_inspecteur')->references('matricule_inspecteur')->on('inspecteur');
            $table->foreign('id_equipe')->references('id_equipe')->on('equipe');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('composer');
    }
};