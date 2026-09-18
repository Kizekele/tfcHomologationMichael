<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion', function (Blueprint $table) {
            $table->id('id_promotion');
            $table->string('nom_promotion', 20);
            $table->string('cycle', 20)->nullable();
            $table->unsignedBigInteger('id_faculte');
            $table->foreign('id_faculte')->references('id_faculte')->on('faculte');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion');
    }
};