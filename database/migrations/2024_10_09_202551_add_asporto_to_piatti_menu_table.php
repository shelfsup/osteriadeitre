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
        Schema::table('piatti_menu', function (Blueprint $table) {
            $table->boolean('asporto')->default(false)->after('prezzo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('piatti_menu', function (Blueprint $table) {
            $table->boolean('asporto')->default(false)->after('prezzo');
        });
    }
};
