<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiant', function (Blueprint $table) {
            $table->string('matricule', 20)->primary();
            $table->string('nom', 50);
            $table->string('postnom', 50)->nullable();
            $table->string('prenom', 50)->nullable();
            $table->enum('sexe', ['M', 'F']);
            $table->string('lieu_naissance', 100)->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('etat_civil', 20)->nullable();
            $table->string('nationalite', 50)->nullable();
            $table->string('nom_pere', 100)->nullable();
            $table->string('nom_mere', 100)->nullable();
            $table->string('province_origine', 50)->nullable();
            $table->string('adresse', 150)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('diplome_acces', 100)->nullable();
            $table->decimal('pourcentage_diplome', 5, 2)->nullable();
            $table->string('section', 50)->nullable();
            $table->string('option_etude', 50)->nullable();
            $table->string('lieu_delivrance', 100)->nullable();
            $table->date('date_delivrance')->nullable();
            $table->string('ecole_provenance', 150)->nullable();
            $table->string('code_ecole', 20)->nullable();
            $table->string('province_ecole', 50)->nullable();
            $table->string('mention', 30)->nullable();
            $table->decimal('pourcentage_bulletin', 5, 2)->nullable();
            $table->unsignedBigInteger('id_promotion');
            $table->foreign('id_promotion')->references('id_promotion')->on('promotion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiant');
    }
};