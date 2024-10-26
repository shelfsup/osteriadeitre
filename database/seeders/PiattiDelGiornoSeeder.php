<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PiattiDelGiornoSeeder extends Seeder
{
    public function run()
    {
        $file = database_path('seeders/data/piatti_del_giorno_adapted.csv');

        if (!file_exists($file)) {
            $this->command->error("Il file $file non esiste.");
            return;
        }

        if (($handle = fopen($file, 'r')) !== false) {
            $header = null;
            $piatti_del_giorno = [];

            while (($line = fgets($handle)) !== false) {
                $line = trim($line);

                if (empty($line)) {
                    continue;
                }

                // Usa str_getcsv per gestire correttamente i campi con virgole
                $fields = str_getcsv($line, ',');

                // Se non abbiamo ancora impostato l'intestazione, impostala
                if (!$header) {
                    $header = $fields;
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
                $piatti_del_giorno[] = [
                    'id' => (int) $piatto['id'],
                    'ordinamento' => (int) $piatto['ordinamento'],
                    'nome_italiano' => $piatto['nome_italiano'],
                    'nome_inglese' => $piatto['nome_inglese'],
                    'descrizione_italiano' => $piatto['descrizione_italiano'],
                    'descrizione_inglese' => $piatto['descrizione_inglese'],
                    'surgelato' => (bool) $piatto['surgelato'],
                    'allergeni' => $piatto['allergeni'],
                    'prezzo' => (float) $piatto['prezzo'],
                    'enable' => (bool) $piatto['enable'],
                    'created_at' => Carbon::parse($piatto['created_at'] ?? Carbon::now()),
                    'updated_at' => Carbon::parse($piatto['updated_at'] ?? Carbon::now()),
                ];
            }

            fclose($handle);

            // Inserisci i piatti del giorno in blocchi
            $chunkSize = 100;
            foreach (array_chunk($piatti_del_giorno, $chunkSize) as $chunk) {
                DB::table('piatti_del_giorno')->insert($chunk);
            }

            $this->command->info("Inseriti " . count($piatti_del_giorno) . " piatti del giorno nella tabella 'piatti_del_giorno'.");
        } else {
            $this->command->error("Impossibile aprire il file $file.");
        }
    }
}
