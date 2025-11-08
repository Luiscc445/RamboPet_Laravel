<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
|
| Aquí se definen las tareas programadas de Laravel.
| El scheduler se ejecuta automáticamente via el contenedor 'scheduler'.
|
*/

// Enviar recordatorios de citas (24 horas antes)
Schedule::command('citas:enviar-recordatorios')->dailyAt('09:00');

// Marcar citas no confirmadas como perdidas
Schedule::command('citas:marcar-perdidas')->dailyAt('23:00');

// Alertas de stock bajo
Schedule::command('inventario:alertas-stock')->dailyAt('08:00');

// Limpieza de logs antiguos
Schedule::command('logs:clear')->weekly();
