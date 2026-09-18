<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mission', function (Blueprint $table) {
            $table->id('id_mission');
            $table->string('numero_lettre', 30);
            $table->date('date_lettre');
            $table->string('motif', 250)->nullable();
            $table->date('periode_debut')->nullable();
            $table->date('periode_fin')->nullable();
            $table->unsignedBigInteger('id_equipe');
            $table->unsignedBigInteger('id_faculte');
            $table->unsignedBigInteger('id_anneeacad');
            $table->foreign('id_equipe')->references('id_equipe')->on('equipe');
            $table->foreign('id_faculte')->references('id_faculte')->on('faculte');
            $table->foreign('id_anneeacad')->references('id_anneeacad')->on('anneeacad');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mission');
    }
};