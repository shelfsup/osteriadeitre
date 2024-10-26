<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategorieMenuTable extends Migration
{
    public function up()
    {
        Schema::create('categorie_menu', function (Blueprint $table) {
            $table->id();
            $table->string('nome_italiano');
            $table->string('nome_inglese');
            $table->timestamps();
        });

        // Inserimento delle categorie di default con nomi in italiano e inglese
        // DB::table('categorie_menu')->insert([
        //     ['nome_italiano' => 'FOOD', 'nome_inglese' => 'FOOD'],
        //     ['nome_italiano' => 'DRINKS', 'nome_inglese' => 'DRINKS'],
        // ]);
    }

    public function down()
    {
        Schema::dropIfExists('categorie_menu');
    }
}
