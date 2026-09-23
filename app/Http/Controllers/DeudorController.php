<?php

namespace App\Http\Controllers;

use App\Models\Deudor;
use Illuminate\Http\Request;

class DeudorController extends Controller
{
    //Display a listing of the resource.
    public function index(Request $request)
    {
        $busqueda = $request->input('q');

        $deudores = Deudor::where('user_id', auth()->id())
            ->when($busqueda, function ($query, $busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%")
                    ->orWhere('email', 'like', "%{$busqueda}%")
                    ->orWhere('telefono', 'like', "%{$busqueda}%");
                });
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->appends($request->query());

        return view('deudores.index', compact('deudores', 'busqueda'));
    }
    
    //Show the form for creating a new resource.
    public function create()
    {
        return view('deudores.create');
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Deudor::create($validated);

        return redirect()
            ->route('deudores.index')
            ->with('success', 'Deudor creado correctamente.');
    }

    //Display the specified resource.
    public function show(Deudor $deudor)
    {
        abort_if($deudor->user_id !== auth()->id(), 403);

        return view('deudores.show', compact('deudor'));
    }

    //Show the form for editing the specified resource.
    public function edit(Deudor $deudor)
    {
        abort_if($deudor->user_id !== auth()->id(), 403);

        return view('deudores.edit', compact('deudor'));
    }

    //Update the specified resource in storage.
    public function update(Request $request, Deudor $deudor)
    {
        abort_if($deudor->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ]);

        $deudor->update($validated);

        return redirect()
            ->route('deudores.show', $deudor)
            ->with('success', 'Deudor actualizado correctamente.');
    }

    //Remove the specified resource from storage.
    public function destroy(Deudor $deudor)
    {
        abort_if($deudor->user_id !== auth()->id(), 403);

        $deudor->delete();

        return redirect()
            ->route('deudores.index')
            ->with('success', 'Deudor eliminado correctamente.');
    }
}

