<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use App\Models\Deudor;
use Illuminate\Http\Request;

class DeudaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->input('q');
        $estado = $request->input('estado');
        $vencimiento = $request->input('vencimiento');

        $deudas = Deuda::whereHas('deudor', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->when($busqueda, function ($query, $busqueda) {
                $query->whereHas('deudor', function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%");
                });
            })
            ->when($estado, function ($query, $estado) {
                $query->where('estado', $estado);
            })
            ->when($vencimiento === 'vencidas', function ($query) {
                $query->vencidas();
            })
            ->when($vencimiento === 'proximas', function ($query) {
                $query->proximasAVencer(7);
            })
            ->when($vencimiento === 'sin_vencimiento', function ($query) {
                $query->whereNull('fecha_vencimiento');
            })
            ->with('deudor')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());

        return view('deudas.index', compact('deudas', 'busqueda', 'estado', 'vencimiento'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // El deudor viene por query string: /deudas/create?deudor_id=2
        $deudor = Deudor::findOrFail($request->query('deudor_id'));
        abort_if($deudor->user_id !== auth()->id(), 403);

        return view('deudas.create', compact('deudor'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'deudor_id' => 'required|exists:deudores,id',
            'descripcion' => 'nullable|string|max:255',
            'monto_total' => 'required|numeric|min:0.01',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        // Verificamos que el deudor pertenezca al usuario logueado
        $deudor = Deudor::findOrFail($validated['deudor_id']);
        abort_if($deudor->user_id !== auth()->id(), 403);

        // Valores por defecto
        $validated['monto_pagado'] = 0;
        $validated['estado'] = Deuda::ESTADO_PENDIENTE;

        $deuda = Deuda::create($validated);

        return redirect()
            ->route('deudores.show', $deudor)
            ->with('success', 'Deuda creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deuda $deuda)
    {
        abort_if($deuda->deudor->user_id !== auth()->id(), 403);

        $deuda->load('deudor', 'pagos');

        return view('deudas.show', compact('deuda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deuda $deuda)
    {
        abort_if($deuda->deudor->user_id !== auth()->id(), 403);

        return view('deudas.edit', compact('deuda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deuda $deuda)
    {
        abort_if($deuda->deudor->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'descripcion' => 'nullable|string|max:255',
            'monto_total' => 'required|numeric|min:0.01',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        // Evitamos que el monto total quede menor a lo ya pagado
        if ($validated['monto_total'] < $deuda->monto_pagado) {
            return back()
                ->withErrors(['monto_total' => 'El monto total no puede ser menor a lo ya pagado.'])
                ->withInput();
        }

        $deuda->update($validated);
        $deuda->actualizarEstado();

        return redirect()
            ->route('deudas.show', $deuda)
            ->with('success', 'Deuda actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deuda $deuda)
    {
        abort_if($deuda->deudor->user_id !== auth()->id(), 403);

        $deudor = $deuda->deudor;
        $deuda->delete();

        return redirect()
            ->route('deudores.show', $deudor)
            ->with('success', 'Deuda eliminada correctamente.');
    }
}
