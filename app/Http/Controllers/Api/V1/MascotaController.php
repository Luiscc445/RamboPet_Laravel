<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MascotaResource;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    /**
     * Listar todas las mascotas
     */
    public function index(Request $request)
    {
        $mascotas = Mascota::with(['tutor', 'especie', 'raza'])
            ->where('activo', true)
            ->paginate(15);

        return MascotaResource::collection($mascotas);
    }

    /**
     * Crear una nueva mascota
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tutor_id' => 'required|exists:tutores,id',
            'especie_id' => 'required|exists:especies,id',
            'raza_id' => 'nullable|exists:razas,id',
            'nombre' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'required|in:macho,hembra',
            'color' => 'nullable|string|max:255',
            'peso' => 'nullable|numeric',
            'microchip' => 'nullable|string|unique:mascotas',
            'esterilizado' => 'boolean',
            'alergias' => 'nullable|string',
            'condiciones_medicas' => 'nullable|string',
            'notas' => 'nullable|string',
        ]);

        $mascota = Mascota::create($validated);
        $mascota->load(['tutor', 'especie', 'raza']);

        return new MascotaResource($mascota);
    }

    /**
     * Mostrar una mascota específica
     */
    public function show(Mascota $mascota)
    {
        $mascota->load(['tutor', 'especie', 'raza', 'citas', 'episodiosClinicos']);

        return new MascotaResource($mascota);
    }

    /**
     * Actualizar una mascota
     */
    public function update(Request $request, Mascota $mascota)
    {
        $validated = $request->validate([
            'tutor_id' => 'sometimes|exists:tutores,id',
            'especie_id' => 'sometimes|exists:especies,id',
            'raza_id' => 'nullable|exists:razas,id',
            'nombre' => 'sometimes|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'sometimes|in:macho,hembra',
            'color' => 'nullable|string|max:255',
            'peso' => 'nullable|numeric',
            'microchip' => 'nullable|string|unique:mascotas,microchip,' . $mascota->id,
            'esterilizado' => 'boolean',
            'alergias' => 'nullable|string',
            'condiciones_medicas' => 'nullable|string',
            'notas' => 'nullable|string',
        ]);

        $mascota->update($validated);
        $mascota->load(['tutor', 'especie', 'raza']);

        return new MascotaResource($mascota);
    }

    /**
     * Eliminar una mascota
     */
    public function destroy(Mascota $mascota)
    {
        $mascota->delete();

        return response()->json([
            'message' => 'Mascota eliminada exitosamente',
        ]);
    }

    /**
     * Obtener historial clínico de una mascota
     */
    public function historial(Mascota $mascota)
    {
        $historial = $mascota->episodiosClinicos()
            ->with('veterinario')
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'mascota' => new MascotaResource($mascota),
            'historial' => $historial,
        ]);
    }
}
