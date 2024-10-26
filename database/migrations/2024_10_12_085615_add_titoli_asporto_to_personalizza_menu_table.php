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
        Schema::table('personalizza_menu', function (Blueprint $table) {
            $table->string('titolo_menu_asporto_italiano')->nullable()->default('MENÙ')->after("titolo_menu_italiano");
            $table->string('titolo_menu_asporto_inglese')->nullable()->default('MENÙ')->after("titolo_menu_italiano");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personalizza_menu', function (Blueprint $table) {
            $table->string('titolo_menu_asporto_italiano')->nullable()->default('MENÙ')->after("titolo_menu_italiano");
            $table->string('titolo_menu_asporto_inglese')->nullable()->default('MENÙ')->after("titolo_menu_italiano");
        });
    }
};
