<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiattiSottoSottocategorieTable extends Migration
{
    public function up()
    {
        Schema::create('piatti_sotto_sottocategorie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sotto_sottocategoria_menu')->constrained('sotto_sottocategorie_menu')->onDelete('cascade');
            $table->string('photo', 2048)->nullable();
            $table->string('nome_italiano');
            $table->string('nome_inglese');
            $table->decimal('prezzo', 8, 2);
            $table->text('descrizione_italiano')->nullable();
            $table->text('descrizione_inglese')->nullable();
            $table->boolean('surgelato')->default(false);
            $table->json('allergeni')->nullable();
            $table->integer('ordinamento')->default(0);
            $table->boolean('enable')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('piatti_sotto_sottocategorie');
    }
}
