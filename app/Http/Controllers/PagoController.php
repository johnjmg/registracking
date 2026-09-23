<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function store(Request $request, Deuda $deuda)
    {
        abort_if($deuda->deudor->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'fecha_pago' => 'required|date',
            'notas' => 'nullable|string',
        ]);

        $saldo = $deuda->saldoPendiente();

        if ($validated['monto'] > $saldo) {
            return back()
                ->withErrors(['monto' => 'El monto no puede ser mayor al saldo pendiente ($' . number_format($saldo, 2) . ').'])
                ->withInput();
        }

        DB::transaction(function () use ($deuda, $validated) {
            $deuda->pagos()->create($validated);

            $deuda->monto_pagado += $validated['monto'];
            $deuda->save();
            $deuda->actualizarEstado();
        });

        return redirect()
            ->route('deudas.show', $deuda)
            ->with('success', 'Pago registrado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $deuda = $pago->deuda;
        abort_if($deuda->deudor->user_id !== auth()->id(), 403);

        DB::transaction(function () use ($pago, $deuda) {
            $deuda->monto_pagado -= $pago->monto;
            $deuda->save();
            $pago->delete();
            $deuda->actualizarEstado();
        });

        return redirect()
            ->route('deudas.show', $deuda)
            ->with('success', 'Pago eliminado correctamente.');
    }
}