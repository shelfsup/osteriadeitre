<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddOrdinamentoToPiattiSottocategorieTable extends Migration
{
    public function up()
    {
        Schema::table('piatti_sottocategorie', function (Blueprint $table) {
            $table->integer('ordinamento')->default(0)->after('id');
        });

        // Imposta i valori di default per 'ordinamento'
        $this->setOrdinamentoDefaults('piatti_sottocategorie');
    }

    public function down()
    {
        Schema::table('piatti_sottocategorie', function (Blueprint $table) {
            $table->dropColumn('ordinamento');
        });
    }

    private function setOrdinamentoDefaults($table)
    {
        $rows = DB::table($table)->orderBy('id')->get();
        foreach ($rows as $index => $row) {
            DB::table($table)->where('id', $row->id)->update(['ordinamento' => $index + 1]);
        }
    }
}

