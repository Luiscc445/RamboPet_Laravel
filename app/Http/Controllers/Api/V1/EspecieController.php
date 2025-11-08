<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Especie;
use Illuminate\Http\Request;

class EspecieController extends Controller
{
    /**
     * Listar todas las especies
     */
    public function index()
    {
        $especies = Especie::where('activo', true)
            ->with('razas')
            ->get();

        return response()->json([
            'data' => $especies,
        ]);
    }

    /**
     * Mostrar una especie específica
     */
    public function show(Especie $especie)
    {
        $especie->load('razas');

        return response()->json([
            'data' => $especie,
        ]);
    }
}
