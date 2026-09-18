<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presenter', function (Blueprint $table) {
            $table->string('matricule_agent', 20);
            $table->unsignedBigInteger('id_mission');
            $table->date('date_presentation')->nullable();
            $table->primary(['matricule_agent', 'id_mission']);
            $table->foreign('matricule_agent')->references('matricule_agent')->on('agent');
            $table->foreign('id_mission')->references('id_mission')->on('mission');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presenter');
    }
};