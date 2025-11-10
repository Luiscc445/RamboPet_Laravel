<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Mascota;
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
            'tipo_consulta' => 'required|in:consulta_general,vacunacion,cirugia,urgencia,control,peluqueria',
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
}
