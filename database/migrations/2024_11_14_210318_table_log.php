<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('LOGS', function (Blueprint $table) {
            $table->id('id_log'); // Colonne ID pour le log
            $table->integer('id_equipe'); // Colonne pour la clé étrangère vers l'équipe
            $table->text('description'); // Colonne pour la description du log
            $table->timestamps();

            // Définir la clé étrangère
            $table->foreign('id_equipe')->references('id')->on('equipe')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
