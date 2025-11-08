<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Raza;
use Illuminate\Http\Request;

class RazaController extends Controller
{
    /**
     * Listar todas las razas
     */
    public function index(Request $request)
    {
        $query = Raza::where('activo', true)
            ->with('especie');

        // Filtrar por especie si se proporciona
        if ($request->has('especie_id')) {
            $query->where('especie_id', $request->especie_id);
        }

        $razas = $query->get();

        return response()->json([
            'data' => $razas,
        ]);
    }

    /**
     * Mostrar una raza específica
     */
    public function show(Raza $raza)
    {
        $raza->load('especie');

        return response()->json([
            'data' => $raza,
        ]);
    }
}
