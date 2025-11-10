<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Especie;
use App\Models\Mascota;
use App\Models\Raza;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileController extends Controller
{
    /**
     * Obtener perfil del tutor asociado al usuario
     */
    public function getTutorProfile(Request $request)
    {
        $user = $request->user();

        // Buscar tutor por email o RUT
        $tutor = Tutor::where('email', $user->email)
            ->orWhere('rut', $user->rut)
            ->first();

        if (!$tutor) {
            // Crear tutor si no existe
            $tutor = Tutor::create([
                'nombre' => $user->name,
                'email' => $user->email,
                'telefono' => $user->telefono,
                'rut' => $user->rut,
                'direccion' => $user->direccion,
            ]);
        }

        return response()->json($tutor);
    }

    /**
     * Listar mascotas del tutor
     */
    public function getMascotas(Request $request)
    {
        $user = $request->user();

        $tutor = Tutor::where('email', $user->email)
            ->orWhere('rut', $user->rut)
            ->first();

        if (!$tutor) {
            return response()->json(['mascotas' => []]);
        }

        $mascotas = Mascota::where('tutor_id', $tutor->id)
            ->with(['especie', 'raza'])
            ->get();

        return response()->json(['mascotas' => $mascotas]);
    }

    /**
     * Registrar nueva mascota
     */
    public function storeMascota(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie_id' => 'required|exists:especies,id',
            'raza_id' => 'nullable|exists:razas,id',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:macho,hembra',
            'color' => 'nullable|string|max:100',
            'peso' => 'nullable|numeric',
            'foto' => 'nullable|image|max:2048', // max 2MB
        ]);

        $user = $request->user();

        $tutor = Tutor::where('email', $user->email)
            ->orWhere('rut', $user->rut)
            ->first();

        if (!$tutor) {
            $tutor = Tutor::create([
                'nombre' => $user->name,
                'email' => $user->email,
                'telefono' => $user->telefono,
                'rut' => $user->rut,
                'direccion' => $user->direccion,
            ]);
        }

        $data = $request->except('foto');
        $data['tutor_id'] = $tutor->id;

        // Subir foto si existe
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('mascotas', 'public');
            $data['foto'] = $path;
        }

        $mascota = Mascota::create($data);

        return response()->json([
            'message' => 'Mascota registrada exitosamente',
            'mascota' => $mascota->load(['especie', 'raza'])
        ], 201);
    }

    /**
     * Listar veterinarios disponibles
     */
    public function getVeterinarios()
    {
        $veterinarios = User::where('rol', 'veterinario')
            ->where('activo', true)
            ->select('id', 'name', 'email', 'telefono')
            ->get();

        return response()->json(['veterinarios' => $veterinarios]);
    }

    /**
     * Crear nueva cita
     */
    public function storeCita(Request $request)
    {
        $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:users,id',
            'fecha_hora' => 'required|date|after:now',
            'tipo_consulta' => 'required|in:consulta_general,vacunacion,cirugia,urgencia,emergencia,control,peluqueria',
            'motivo' => 'nullable|string',
        ]);

        // Verificar que la mascota pertenece al tutor
        $user = $request->user();
        $tutor = Tutor::where('email', $user->email)->orWhere('rut', $user->rut)->first();
        $mascota = Mascota::findOrFail($request->mascota_id);

        if ($mascota->tutor_id !== $tutor->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $cita = Cita::create([
            'mascota_id' => $request->mascota_id,
            'veterinario_id' => $request->veterinario_id,
            'fecha_hora' => $request->fecha_hora,
            'tipo_consulta' => $request->tipo_consulta,
            'motivo' => $request->motivo,
            'estado' => 'pendiente',
            'confirmada' => false,
        ]);

        return response()->json([
            'message' => 'Cita agendada exitosamente',
            'cita' => $cita->load(['mascota', 'veterinario'])
        ], 201);
    }

    /**
     * Listar citas del usuario
     */
    public function getCitas(Request $request)
    {
        $user = $request->user();
        $tutor = Tutor::where('email', $user->email)->orWhere('rut', $user->rut)->first();

        if (!$tutor) {
            return response()->json(['citas' => []]);
        }

        $mascotasIds = Mascota::where('tutor_id', $tutor->id)->pluck('id');

        $citas = Cita::whereIn('mascota_id', $mascotasIds)
            ->with(['mascota', 'veterinario'])
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return response()->json(['citas' => $citas]);
    }

    /**
     * Cancelar cita
     */
    public function cancelCita(Request $request, $id)
    {
        $user = $request->user();
        $tutor = Tutor::where('email', $user->email)->orWhere('rut', $user->rut)->first();

        $cita = Cita::findOrFail($id);
        $mascota = Mascota::findOrFail($cita->mascota_id);

        if ($mascota->tutor_id !== $tutor->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $cita->update(['estado' => 'cancelada']);

        return response()->json([
            'message' => 'Cita cancelada exitosamente',
            'cita' => $cita
        ]);
    }

    /**
     * Ver detalle de una cita específica
     */
    public function getCita(Request $request, $id)
    {
        $user = $request->user();
        $tutor = Tutor::where('email', $user->email)->orWhere('rut', $user->rut)->first();

        if (!$tutor) {
            return response()->json(['message' => 'Tutor no encontrado'], 404);
        }

        $cita = Cita::with(['mascota.especie', 'mascota.raza', 'veterinario'])->findOrFail($id);
        $mascota = $cita->mascota;

        if ($mascota->tutor_id !== $tutor->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json(['cita' => $cita]);
    }

    /**
     * Listar especies disponibles
     */
    public function getEspecies()
    {
        $especies = Especie::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return response()->json(['especies' => $especies]);
    }

    /**
     * Listar razas por especie
     */
    public function getRazas(Request $request)
    {
        $especieId = $request->query('especie_id');

        $query = Raza::where('activo', true);

        if ($especieId) {
            $query->where('especie_id', $especieId);
        }

        $razas = $query->with('especie')->orderBy('nombre')->get();

        return response()->json(['razas' => $razas]);
    }

    /**
     * Actualizar mascota
     */
    public function updateMascota(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'especie_id' => 'sometimes|exists:especies,id',
            'raza_id' => 'nullable|exists:razas,id',
            'fecha_nacimiento' => 'sometimes|date',
            'sexo' => 'sometimes|in:macho,hembra',
            'color' => 'nullable|string|max:100',
            'peso' => 'nullable|numeric',
            'foto' => 'nullable|image|max:2048',
            'alergias' => 'nullable|string',
            'condiciones_medicas' => 'nullable|string',
            'esterilizado' => 'nullable|boolean',
        ]);

        $user = $request->user();
        $tutor = Tutor::where('email', $user->email)->orWhere('rut', $user->rut)->first();

        if (!$tutor) {
            return response()->json(['message' => 'Tutor no encontrado'], 404);
        }

        $mascota = Mascota::findOrFail($id);

        if ($mascota->tutor_id !== $tutor->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $data = $request->except('foto');

        // Subir nueva foto si existe
        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($mascota->foto) {
                Storage::disk('public')->delete($mascota->foto);
            }
            $path = $request->file('foto')->store('mascotas', 'public');
            $data['foto'] = $path;
        }

        $mascota->update($data);

        return response()->json([
            'message' => 'Mascota actualizada exitosamente',
            'mascota' => $mascota->load(['especie', 'raza'])
        ]);
    }

    /**
     * Eliminar mascota
     */
    public function deleteMascota(Request $request, $id)
    {
        $user = $request->user();
        $tutor = Tutor::where('email', $user->email)->orWhere('rut', $user->rut)->first();

        if (!$tutor) {
            return response()->json(['message' => 'Tutor no encontrado'], 404);
        }

        $mascota = Mascota::findOrFail($id);

        if ($mascota->tutor_id !== $tutor->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Verificar si tiene citas pendientes
        $citasPendientes = Cita::where('mascota_id', $mascota->id)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->count();

        if ($citasPendientes > 0) {
            return response()->json([
                'message' => 'No se puede eliminar la mascota porque tiene citas pendientes o confirmadas'
            ], 400);
        }

        // Eliminar foto si existe
        if ($mascota->foto) {
            Storage::disk('public')->delete($mascota->foto);
        }

        $mascota->delete();

        return response()->json([
            'message' => 'Mascota eliminada exitosamente'
        ]);
    }

    /**
     * Actualizar perfil del tutor
     */
    public function updateTutorProfile(Request $request)
    {
        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'telefono' => 'sometimes|string|max:20',
            'celular' => 'sometimes|string|max:20',
            'direccion' => 'sometimes|string|max:255',
            'comuna' => 'sometimes|string|max:100',
            'region' => 'sometimes|string|max:100',
        ]);

        $user = $request->user();

        $tutor = Tutor::where('email', $user->email)
            ->orWhere('rut', $user->rut)
            ->first();

        if (!$tutor) {
            // Crear tutor si no existe
            $tutor = Tutor::create([
                'nombre' => $user->name,
                'email' => $user->email,
                'telefono' => $user->telefono,
                'rut' => $user->rut,
                'direccion' => $user->direccion,
            ]);
        }

        $tutor->update($request->only([
            'nombre',
            'apellido',
            'telefono',
            'celular',
            'direccion',
            'comuna',
            'region',
        ]));

        // También actualizar algunos campos en el usuario
        $user->update([
            'name' => $request->nombre ?? $user->name,
            'telefono' => $request->telefono ?? $user->telefono,
            'direccion' => $request->direccion ?? $user->direccion,
        ]);

        return response()->json([
            'message' => 'Perfil actualizado exitosamente',
            'tutor' => $tutor
        ]);
    }
}
