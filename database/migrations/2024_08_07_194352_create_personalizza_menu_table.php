<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePersonalizzaMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalizza_menu', function (Blueprint $table) {
            $table->id();
            $table->string('titolo_italiano')->nullable()->default('APERITIVO');
            $table->string('titolo_inglese')->nullable()->default('APERITIF');
            $table->string('sottotitolo_italiano')->nullable()->default('FOOD AND DRINKS');
            $table->string('sottotitolo_inglese')->nullable()->default('FOOD AND DRINKS');
            $table->string('titolo_menu_italiano')->nullable()->default('MENÙ');
            $table->string('titolo_menu_inglese')->nullable()->default('MENÙ');
            $table->string('titolo_social_italiano')->nullable()->default('SEGUICI SUI NOSTRI SOCIAL');
            $table->string('titolo_social_inglese')->nullable()->default('FOLLOW US ON OUR SOCIAL NETWORKS');
            $table->timestamps();
        });

        // Inserisci un record con i valori di default
        DB::table('personalizza_menu')->insert([
            'titolo_italiano' => 'APERITIVO',
            'titolo_inglese' => 'APERITIF',
            'sottotitolo_italiano' => 'FOOD AND DRINKS',
            'sottotitolo_inglese' => 'FOOD AND DRINKS',
            'titolo_menu_italiano' => 'MENÙ',
            'titolo_menu_inglese' => 'MENÙ',
            'titolo_social_italiano' => 'SEGUICI SUI NOSTRI SOCIAL',
            'titolo_social_inglese' => 'FOLLOW US ON OUR SOCIAL NETWORKS',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personalizza_menu');
    }
}
