<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSottocategorieMenuTable extends Migration
{
    public function up()
    {
        Schema::create('sottocategorie_menu', function (Blueprint $table) {
            $table->id();
            $table->string('nome_italiano');
            $table->string('nome_inglese');
            $table->text('descrizione_italiano')->nullable();
            $table->text('descrizione_inglese')->nullable();
            $table->foreignId('id_categoria_menu')->constrained('categorie_menu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sottocategorie_menu');
    }
}
