<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PiattiMenuSeeder extends Seeder
{
    public function run()
    {
        $file = database_path('seeders/data/piatti_menu_adapted.csv');

        if (!file_exists($file)) {
            $this->command->error("Il file $file non esiste.");
            return;
        }

        if (($handle = fopen($file, 'r')) !== false) {
            $header = null;
            $piatti = [];

            while (($line = fgets($handle)) !== false) {
                $line = trim($line);

                if (empty($line)) {
                    continue;
                }

                // Usa str_getcsv per gestire correttamente i campi con virgole all'interno
                $fields = str_getcsv($line, ',');

                // Se non abbiamo ancora impostato l'intestazione, impostala
                if (!$header) {
                    $header = $fields; // Prendi tutte le colonne
                    continue;
                }

                // Verifica che il numero di colonne corrisponda
                if (count($fields) !== count($header)) {
                    $this->command->warn("Riga malformata trovata e ignorata: $line");
                    continue;
                }

                // Combina l'intestazione con i campi della riga
                $piatto = array_combine($header, $fields);

                if ($piatto === false) {
                    $this->command->warn("Impossibile combinare header e riga: $line");
                    continue;
                }

                // Prepara l'array per l'inserimento
                $piatti[] = [
                    'id' => (int) $piatto['id'],
                    'ordinamento' => (int) $piatto['ordinamento'],
                    'nome_italiano' => $piatto['nome_italiano'],
                    'nome_inglese' => $piatto['nome_inglese'],
                    'prezzo' => (float) $piatto['prezzo'],
                    'prezzo_asporto' => (float) $piatto['prezzo_asporto'],
                    'asporto' => (bool) $piatto['asporto'],
                    'solo_asporto' => (bool) $piatto['solo_asporto'],
                    'photo' => $piatto['photo'],
                    'descrizione_italiano' => $piatto['descrizione_italiano'],
                    'descrizione_inglese' => $piatto['descrizione_inglese'],
                    'show_desc' => (bool) $piatto['show_desc'],
                    'surgelato' => (bool) $piatto['surgelato'],
                    'allergeni' => $piatto['allergeni'],
                    'id_categoria_menu' => (int) $piatto['id_categoria_menu'],
                    'enable' => (bool) $piatto['enable'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            fclose($handle);

            // Inserisci i piatti in blocchi
            $chunkSize = 100;
            foreach (array_chunk($piatti, $chunkSize) as $chunk) {
                DB::table('piatti_menu')->insert($chunk);
            }

            $this->command->info("Inseriti " . count($piatti) . " piatti nella tabella 'piatti_menu'.");
        } else {
            $this->command->error("Impossibile aprire il file $file.");
        }
    }
}
