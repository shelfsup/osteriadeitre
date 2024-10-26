<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CategorieMenu;
use Illuminate\Support\Facades\DB;

class AddOrdinamentoToCategorieMenuTable extends Migration
{
    public function up()
    {
        Schema::table('categorie_menu', function (Blueprint $table) {
            $table->integer('ordinamento')->default(0)->after('id');
        });

        // Imposta i valori di default per 'ordinamento'
        $this->setOrdinamentoDefaults('categorie_menu');
    }

    public function down()
    {
        Schema::table('categorie_menu', function (Blueprint $table) {
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
