<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSottoSottocategorieMenuTable extends Migration
{
    public function up()
    {
        Schema::create('sotto_sottocategorie_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sottocategoria_menu')->constrained('sottocategorie_menu')->onDelete('cascade');
            $table->integer('ordinamento')->default(0);
            $table->string('nome_italiano');
            $table->string('nome_inglese');
            $table->text('descrizione_italiano')->nullable();
            $table->text('descrizione_inglese')->nullable();
            $table->boolean('enable')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sotto_sottocategorie_menu');
    }
}
