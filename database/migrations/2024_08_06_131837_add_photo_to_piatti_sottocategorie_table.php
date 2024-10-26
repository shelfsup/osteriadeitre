            $table->string('photo')->nullable()->after('prezzo'); // Aggiunge la colonna 'photo' dopo 'prezzo'
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
        Schema::table('piatti_sottocategorie', function (Blueprint $table) {
            $table->string('photo', 2048)->nullable()->after('prezzo'); // Aggiunge la colonna 'photo' dopo 'prezzo'
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('piatti_sottocategorie', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('prezzo'); // Aggiunge la colonna 'photo' dopo 'prezzo'
            //
        });
    }
};
