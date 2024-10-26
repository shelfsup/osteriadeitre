<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SottocategorieMenuSeeder extends Seeder
{
    public function run()
    {
        $file = database_path('seeders/data/sottocategorie_menu_adapted.csv');

        // Verifica se il file esiste
        if (!file_exists($file)) {
            $this->command->error("Il file $file non esiste.");
            return;
        }

        // Apri il file per la lettura
        if (($handle = fopen($file, 'r')) !== false) {
            $header = null;
            $sottocategorie = [];

            while (($line = fgets($handle)) !== false) {
                $line = trim($line);

                // Salta le righe vuote
                if (empty($line)) {
                    continue;
                }

                // Rimuovi le virgolette iniziali e finali
                $line = trim($line, '"');

                // Dividi la riga utilizzando il punto e virgola come delimitatore
                $fields = explode(',', $line);

                // Se non abbiamo ancora impostato l'intestazione, impostala
                if (!$header) {
                    $header = $fields; // Prendi tutte le colonne
                    continue;
                }

                // Combina l'intestazione con i campi della riga
                $sottocategoria = array_combine($header, $fields);

                if ($sottocategoria === false) {
                    $this->command->warn("Impossibile combinare header e riga: $line");
                    continue;
                }

                // Prepara l'array per l'inserimento
                $sottocategorie[] = [
                    'id' => (int) $sottocategoria['id'],
                    'ordinamento' => (int) $sottocategoria['ordinamento'],
                    'nome_italiano' => $sottocategoria['nome_italiano'],
                    'nome_inglese' => $sottocategoria['nome_inglese'],
                    'descrizione_italiano' => $sottocategoria['descrizione_italiano'],
                    'descrizione_inglese' => $sottocategoria['descrizione_inglese'],
                    'enable' => (bool) $sottocategoria['enable'],
                    'id_categoria_menu' => (int) $sottocategoria['id_categoria_menu'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            fclose($handle);

            // Inserisci le sottocategorie in blocchi
            $chunkSize = 100;
            foreach (array_chunk($sottocategorie, $chunkSize) as $chunk) {
                DB::table('sottocategorie_menu')->insert($chunk);
            }

            $this->command->info("Inserite " . count($sottocategorie) . " sottocategorie nella tabella 'sottocategorie_menu'.");
        } else {
            $this->command->error("Impossibile aprire il file $file.");
        }
    }
}
