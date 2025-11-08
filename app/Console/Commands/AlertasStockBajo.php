<?php

namespace App\Console\Commands;

use App\Models\Producto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AlertasStockBajo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventario:alertas-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar alertas de productos con stock bajo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando stock de productos...');

        // Buscar productos con stock bajo
        $productos = Producto::where('activo', true)
            ->whereColumn('stock_actual', '<=', 'stock_minimo')
            ->get();

        if ($productos->isEmpty()) {
            $this->info('No hay productos con stock bajo.');
            return 0;
        }

        $this->warn("¡ALERTA! Se encontraron {$productos->count()} productos con stock bajo:");

        foreach ($productos as $producto) {
            $this->line("- {$producto->nombre} (Stock: {$producto->stock_actual}/{$producto->stock_minimo})");

            // Registrar en el log
            Log::warning("Stock bajo: {$producto->nombre}", [
                'producto_id' => $producto->id,
                'stock_actual' => $producto->stock_actual,
                'stock_minimo' => $producto->stock_minimo,
            ]);

            // Aquí se podría enviar una notificación al administrador
            // Notification::send($admins, new StockBajoNotification($producto));
        }

        $this->info('Alertas de stock generadas.');

        return 0;
    }
}
