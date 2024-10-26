<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoToPiattiMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('piatti_menu', function (Blueprint $table) {
            $table->string('photo', 2048)->nullable()->after('prezzo'); // Aggiunge la colonna 'photo' dopo 'prezzo'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('piatti_menu', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
}
