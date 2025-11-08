<?php

namespace App\Jobs;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarRecordatorioCita implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * La cita para la que se enviará el recordatorio
     */
    protected $cita;

    /**
     * Create a new job instance.
     */
    public function __construct(Cita $cita)
    {
        $this->cita = $cita;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Verificar que la cita aún esté vigente
        if (!in_array($this->cita->estado, ['pendiente', 'confirmada'])) {
            Log::info("Recordatorio no enviado - Cita ID {$this->cita->id} no está en estado válido");
            return;
        }

        // Verificar que el recordatorio no haya sido enviado
        if ($this->cita->recordatorio_enviado) {
            Log::info("Recordatorio ya enviado para Cita ID {$this->cita->id}");
            return;
        }

        try {
            // Cargar relaciones necesarias
            $this->cita->load(['mascota.tutor', 'veterinario']);

            $tutor = $this->cita->mascota->tutor;
            $mascota = $this->cita->mascota;

            // Aquí iría la lógica de envío de email o SMS
            // Por ahora solo registramos en el log
            $mensaje = "Recordatorio de cita para {$mascota->nombre} " .
                      "el día {$this->cita->fecha_hora->format('d/m/Y')} " .
                      "a las {$this->cita->fecha_hora->format('H:i')}. " .
                      "Veterinario: {$this->cita->veterinario->name}. " .
                      "Tipo: {$this->cita->tipo_consulta}.";

            Log::info("Recordatorio enviado a {$tutor->nombre_completo}", [
                'cita_id' => $this->cita->id,
                'tutor_celular' => $tutor->celular,
                'mensaje' => $mensaje,
            ]);

            // Aquí se podría integrar con un servicio de SMS o Email
            // Mail::to($tutor->email)->send(new RecordatorioCitaMail($this->cita));

            // Marcar como enviado
            $this->cita->update([
                'recordatorio_enviado' => true,
            ]);

            Log::info("Recordatorio marcado como enviado para Cita ID {$this->cita->id}");

        } catch (\Exception $e) {
            Log::error("Error al enviar recordatorio para Cita ID {$this->cita->id}: " . $e->getMessage());
            throw $e;
        }
    }
}
