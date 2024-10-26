<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorieMenuSeeder extends Seeder
{
    public function run()
    {
        // Svuota la tabella prima di eseguire il seeder
        // DB::table('categorie_menu')->truncate();

        $file = database_path('seeders/data/categorie_menu_adapted.csv');

        if (!file_exists($file)) {
            $this->command->error("Il file $file non esiste.");
            return;
        }

        if (($handle = fopen($file, 'r')) !== false) {
            $header = null;
            $categorie = [];

            while (($line = fgets($handle)) !== false) {
                $line = trim($line);

                if (empty($line)) {
                    continue;
                }

                $line = trim($line, '"');
                $fields = explode(',', $line);

                if (!$header) {
                    $header = $fields;
                    continue;
                }

                $categoria = array_combine($header, $fields);

                if ($categoria === false) {
                    $this->command->warn("Impossibile combinare header e riga: $line");
                    continue;
                }

                $categorie[] = [
                    'id' => (int) $categoria['id'],
                    'ordinamento' => (int) $categoria['ordinamento'],
                    'nome_italiano' => $categoria['nome_italiano'],
                    'nome_inglese' => $categoria['nome_inglese'],
                    'enable' => (bool) $categoria['enable'],
                    'created_at' => $categoria['created_at'] ? Carbon::parse($categoria['created_at']) : Carbon::now(),
                    'updated_at' => $categoria['updated_at'] ? Carbon::parse($categoria['updated_at']) : Carbon::now(),
                ];
            }

            fclose($handle);

            $chunkSize = 100;
            foreach (array_chunk($categorie, $chunkSize) as $chunk) {
                DB::table('categorie_menu')->insert($chunk);
            }

            $this->command->info("Inserite " . count($categorie) . " categorie nella tabella 'categorie_menu'.");
        } else {
            $this->command->error("Impossibile aprire il file $file.");
        }
    }
}
