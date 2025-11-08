<?php

namespace App\Console\Commands;

use App\Models\Cita;
use Illuminate\Console\Command;

class MarcarCitasPerdidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'citas:marcar-perdidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marcar como perdidas las citas no confirmadas que ya pasaron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Buscando citas no confirmadas que ya pasaron...');

        // Buscar citas pasadas que no fueron completadas ni canceladas
        $citas = Cita::where('fecha_hora', '<', now())
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->get();

        if ($citas->isEmpty()) {
            $this->info('No hay citas para marcar como perdidas.');
            return 0;
        }

        $this->info("Se encontraron {$citas->count()} citas para marcar como perdidas.");

        foreach ($citas as $cita) {
            $cita->update([
                'estado' => 'perdida',
            ]);
        }

        $this->info('Citas marcadas como perdidas exitosamente.');

        return 0;
    }
}
