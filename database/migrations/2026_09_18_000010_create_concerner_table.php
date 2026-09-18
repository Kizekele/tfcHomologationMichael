<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('concerner', function (Blueprint $table) {
            $table->unsignedBigInteger('id_promotion');
            $table->unsignedBigInteger('id_anneeacad');
            $table->primary(['id_promotion', 'id_anneeacad']);
            $table->foreign('id_promotion')->references('id_promotion')->on('promotion');
            $table->foreign('id_anneeacad')->references('id_anneeacad')->on('anneeacad');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('concerner');
    }
};