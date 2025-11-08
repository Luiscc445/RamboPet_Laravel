<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Listar todos los productos
     */
    public function index(Request $request)
    {
        $query = Producto::where('activo', true);

        // Filtros opcionales
        if ($request->has('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->has('stock_bajo')) {
            $query->whereColumn('stock_actual', '<=', 'stock_minimo');
        }

        $productos = $query->paginate(15);

        return ProductoResource::collection($productos);
    }

    /**
     * Mostrar un producto específico
     */
    public function show(Producto $producto)
    {
        $producto->load('lotes');

        return new ProductoResource($producto);
    }
}
