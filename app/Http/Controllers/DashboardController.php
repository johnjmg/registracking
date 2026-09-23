<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use App\Models\Deudor;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Resumen general
        $totalDeudores = Deudor::where('user_id', $userId)->count();

        $deudasQuery = Deuda::whereHas('deudor', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        $totalDeudas = $deudasQuery->count();

        // Suma de saldos pendientes (monto_total - monto_pagado) de deudas no pagadas
        $totalAdeudado = (clone $deudasQuery)
            ->pendientes()
            ->sum(\DB::raw('monto_total - monto_pagado'));

        $totalPagado = (clone $deudasQuery)->sum('monto_pagado');

        $deudasPendientes = (clone $deudasQuery)->pendientes()->count();
        $deudasPagadas = (clone $deudasQuery)
            ->where('estado', Deuda::ESTADO_PAGADO)
            ->count();

        // Alertas
        $deudasVencidas = (clone $deudasQuery)
            ->vencidas()
            ->with('deudor')
            ->orderBy('fecha_vencimiento')
            ->get();

        $deudasProximas = (clone $deudasQuery)
            ->proximasAVencer(7)
            ->with('deudor')
            ->orderBy('fecha_vencimiento')
            ->get();

        // Deudas pendientes recientes (para el listado general)
        $deudasRecientes = (clone $deudasQuery)
            ->pendientes()
            ->with('deudor')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalDeudores',
            'totalDeudas',
            'totalAdeudado',
            'totalPagado',
            'deudasPendientes',
            'deudasPagadas',
            'deudasVencidas',
            'deudasProximas',
            'deudasRecientes'
        ));
    }
}