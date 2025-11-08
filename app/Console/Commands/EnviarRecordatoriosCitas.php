<?php

namespace App\Console\Commands;

use App\Jobs\EnviarRecordatorioCita;
use App\Models\Cita;
use Illuminate\Console\Command;

class EnviarRecordatoriosCitas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'citas:enviar-recordatorios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar recordatorios de citas programadas para las próximas 24 horas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Buscando citas para enviar recordatorios...');

        // Buscar citas en las próximas 24 horas que no tengan recordatorio enviado
        $citas = Cita::whereBetween('fecha_hora', [now(), now()->addDay()])
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->where('recordatorio_enviado', false)
            ->get();

        if ($citas->isEmpty()) {
            $this->info('No hay citas pendientes con recordatorio.');
            return 0;
        }

        $this->info("Se encontraron {$citas->count()} citas para enviar recordatorios.");

        $bar = $this->output->createProgressBar($citas->count());
        $bar->start();

        foreach ($citas as $cita) {
            // Despachar el job a la cola
            EnviarRecordatorioCita::dispatch($cita);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Recordatorios enviados a la cola exitosamente.');

        return 0;
    }
}
