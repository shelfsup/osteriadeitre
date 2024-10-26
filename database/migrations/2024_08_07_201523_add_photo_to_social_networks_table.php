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
        Schema::table('social_networks', function (Blueprint $table) {
            $table->string('photo', 2048)->nullable()->after('link_profilo'); // Aggiunge la colonna 'photo' dopo 'prezzo'
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_networks', function (Blueprint $table) {
            $table->string('photo', 2048)->nullable()->after('link_profilo'); // Aggiunge la colonna 'photo' dopo 'prezzo'
            //
        });
    }
};
