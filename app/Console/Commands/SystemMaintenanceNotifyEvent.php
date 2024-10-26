<?php

namespace App\Console\Commands;

use App\Events\SystemMaintenanceEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SystemMaintenanceNotifyEvent extends Command
{
    protected $signature = 'app:system-maintenance-notify-event';
    protected $description = 'Notifica gli utenti che a breve il server sarà in manutenzione';

    public function handle()
    {
        $event = $this->ask('
        Seleziona tipologia:
        m) Maintenance Message
        c) Custom Message
        ');
        if ($event == 'm') {
            $title = 'Messaggio di sistema';
            $message = 'Il server sarà a breve in manutenzione. Ci scusiamo per il disagio.';
        } else if ($event == 'c') {
            $title = $this->ask('Titolo modal');
            $message = $this->ask('Messaggio');
        } else {
            $this->error('Tipologia non valida. Per favore seleziona "m" o "c".');
            return;
        }

        event(new SystemMaintenanceEvent($title, $message));
    }
}
