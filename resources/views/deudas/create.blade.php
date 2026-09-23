<x-app-layout>
    <x-slot name="title">
        Nueva Deuda
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Deuda para {{ $deudor->nombre }} {{ $deudor->apellido }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('deudas.store') }}">
                        @csrf
                        <input type="hidden" name="deudor_id" value="{{ $deudor->id }}">

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Descripción</label>
                            <input type="text" name="descripcion" value="{{ old('descripcion') }}"
                                   class="w-full border rounded px-3 py-2"
                                   placeholder="Ej: Préstamo, compra, servicio...">
                            @error('descripcion')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Monto total *</label>
                            <input type="number" step="0.01" min="0.01" name="monto_total"
                                   value="{{ old('monto_total') }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('monto_total')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Fecha de vencimiento</label>
                            <input type="date" name="fecha_vencimiento"
                                   value="{{ old('fecha_vencimiento') }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('fecha_vencimiento')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('deudores.show', $deudor) }}"
                               class="px-4 py-2 border rounded">Cancelar</a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Guardar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>