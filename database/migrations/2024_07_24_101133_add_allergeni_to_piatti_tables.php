<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllergeniToPiattiTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('piatti_menu', function (Blueprint $table) {
            $table->json('allergeni')->nullable()->after('descrizione_inglese');
        });

        Schema::table('piatti_sottocategorie', function (Blueprint $table) {
            $table->json('allergeni')->nullable()->after('descrizione_inglese');
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
            $table->dropColumn('allergeni');
        });

        Schema::table('piatti_sottocategorie', function (Blueprint $table) {
            $table->dropColumn('allergeni');
        });
    }
}
