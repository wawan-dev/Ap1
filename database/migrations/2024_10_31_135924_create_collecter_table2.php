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
        Schema::create('COLLECTER', function (Blueprint $table) {
            $table->integer('idequipe'); // Utilisez integer et unsigned pour correspondre aux colonnes existantes
            $table->integer('idadministrateur');
            $table->timestamp('date')->useCurrent();
            $table->text('commentaire')->nullable();

            $table->foreign('idequipe')->references('idequipe')->on('EQUIPE')->onDelete('cascade');
            $table->foreign('idadministrateur')->references('idadministrateur')->on('ADMINISTRATEUR')->onDelete('cascade');

            $table->primary(['idequipe', 'idadministrateur', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('COLLECTER');
    }
};
