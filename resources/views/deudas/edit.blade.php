<x-app-layout>
    <x-slot name="title">
        Editar Deuda
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Deuda
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <p class="mb-4 text-gray-600">
                        Deudor: <strong>{{ $deuda->deudor->nombre }} {{ $deuda->deudor->apellido }}</strong>
                    </p>

                    <form method="POST" action="{{ route('deudas.update', $deuda) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Descripción</label>
                            <input type="text" name="descripcion"
                                   value="{{ old('descripcion', $deuda->descripcion) }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('descripcion')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Monto total *</label>
                            <input type="number" step="0.01" min="0.01" name="monto_total"
                                   value="{{ old('monto_total', $deuda->monto_total) }}"
                                   class="w-full border rounded px-3 py-2">
                            <p class="text-gray-500 text-sm mt-1">
                                Ya pagado: ${{ number_format($deuda->monto_pagado, 2) }}.
                                El nuevo monto no puede ser menor a eso.
                            </p>
                            @error('monto_total')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Fecha de vencimiento</label>
                            <input type="date" name="fecha_vencimiento"
                                   value="{{ old('fecha_vencimiento', $deuda->fecha_vencimiento?->format('Y-m-d')) }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('fecha_vencimiento')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('deudas.show', $deuda) }}"
                               class="px-4 py-2 border rounded">Cancelar</a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Actualizar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>