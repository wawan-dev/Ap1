<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('COLLECTER', function (Blueprint $table) {
            $table->unsignedBigInteger('idequipe');
            $table->unsignedBigInteger('idadministrateur');
            $table->date('date');
            $table->text('commentaire')->nullable(); // Nouveau champ commentaire

            // Définir la clé primaire composite
            $table->primary(['idequipe', 'idadministrateur', 'date']);

            // Définir les clés étrangères
            $table->foreign('idequipe')->references('idequipe')->on('EQUIPE')->onDelete('cascade');
            $table->foreign('idadministrateur')->references('idadministrateur')->on('ADMINISTRATEUR')->onDelete('cascade');

            $table->timestamps(); // Ajout de created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collecter');
    }
};
