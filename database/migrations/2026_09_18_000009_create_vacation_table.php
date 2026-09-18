<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacation', function (Blueprint $table) {
            $table->id('id_vacation');
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement')->nullable();
            $table->string('matricule_inspecteur', 20);
            $table->unsignedBigInteger('id_mission');
            $table->foreign('matricule_inspecteur')->references('matricule_inspecteur')->on('inspecteur');
            $table->foreign('id_mission')->references('id_mission')->on('mission');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacation');
    }
};