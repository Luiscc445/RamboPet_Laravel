<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitaResource;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Listar todas las citas
     */
    public function index(Request $request)
    {
        $query = Cita::with(['mascota.tutor', 'veterinario']);

        // Filtros opcionales
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('fecha_desde')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_hasta);
        }

        $citas = $query->orderBy('fecha_hora', 'asc')->paginate(15);

        return CitaResource::collection($citas);
    }

    /**
     * Crear una nueva cita
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:users,id',
            'tipo_consulta' => 'required|in:consulta_general,vacunacion,cirugia,control,emergencia',
            'fecha_hora' => 'required|date|after:now',
            'duracion_minutos' => 'required|integer|min:15|max:240',
            'motivo' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $validated['estado'] = 'pendiente';
        $validated['creado_por'] = $request->user()->id;

        $cita = Cita::create($validated);
        $cita->load(['mascota.tutor', 'veterinario']);

        return new CitaResource($cita);
    }

    /**
     * Mostrar una cita específica
     */
    public function show(Cita $cita)
    {
        $cita->load(['mascota.tutor', 'veterinario', 'episodioClinico']);

        return new CitaResource($cita);
    }

    /**
     * Actualizar una cita
     */
    public function update(Request $request, Cita $cita)
    {
        $validated = $request->validate([
            'mascota_id' => 'sometimes|exists:mascotas,id',
            'veterinario_id' => 'sometimes|exists:users,id',
            'tipo_consulta' => 'sometimes|in:consulta_general,vacunacion,cirugia,control,emergencia',
            'fecha_hora' => 'sometimes|date',
            'duracion_minutos' => 'sometimes|integer|min:15|max:240',
            'estado' => 'sometimes|in:pendiente,confirmada,en_curso,completada,cancelada,perdida',
            'motivo' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $cita->update($validated);
        $cita->load(['mascota.tutor', 'veterinario']);

        return new CitaResource($cita);
    }

    /**
     * Eliminar una cita
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();

        return response()->json([
            'message' => 'Cita eliminada exitosamente',
        ]);
    }

    /**
     * Obtener citas próximas (24 horas)
     */
    public function proximas(Request $request)
    {
        $citas = Cita::proximas()
            ->with(['mascota.tutor', 'veterinario'])
            ->orderBy('fecha_hora', 'asc')
            ->get();

        return CitaResource::collection($citas);
    }

    /**
     * Confirmar una cita
     */
    public function confirmar(Cita $cita)
    {
        $cita->update([
            'estado' => 'confirmada',
            'confirmada' => true,
        ]);

        $cita->load(['mascota.tutor', 'veterinario']);

        return new CitaResource($cita);
    }

    /**
     * Cancelar una cita
     */
    public function cancelar(Request $request, Cita $cita)
    {
        $validated = $request->validate([
            'motivo' => 'nullable|string',
        ]);

        $cita->update([
            'estado' => 'cancelada',
            'observaciones' => $validated['motivo'] ?? 'Cancelada por el usuario',
        ]);

        $cita->load(['mascota.tutor', 'veterinario']);

        return new CitaResource($cita);
    }
}
