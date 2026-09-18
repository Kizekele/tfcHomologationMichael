<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homologuer', function (Blueprint $table) {
            $table->string('matricule', 20);
            $table->unsignedBigInteger('id_mission');
            $table->enum('avis', ['Favorable', 'Défavorable']);
            $table->date('date_avis')->nullable();
            $table->string('observation', 250)->nullable();
            $table->string('numero_fiche', 30)->nullable();
            $table->primary(['matricule', 'id_mission']);
            $table->foreign('matricule')->references('matricule')->on('etudiant');
            $table->foreign('id_mission')->references('id_mission')->on('mission');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homologuer');
    }
};