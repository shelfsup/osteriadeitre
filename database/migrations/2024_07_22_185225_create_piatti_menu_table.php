<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiattiMenuTable extends Migration
{
    public function up()
    {
        Schema::create('piatti_menu', function (Blueprint $table) {
            $table->id();
            $table->string('nome_italiano');
            $table->string('nome_inglese');
            $table->decimal('prezzo', 8, 2);
            $table->text('descrizione_italiano')->nullable();
            $table->text('descrizione_inglese')->nullable();
            $table->foreignId('id_categoria_menu')->constrained('categorie_menu')->onDelete('cascade');
            $table->boolean('enable')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('piatti_menu');
    }
}
