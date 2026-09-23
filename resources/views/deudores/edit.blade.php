<x-app-layout>
    <x-slot name="title">
        Editar Deudor
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Deudor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('deudores.update', $deudor) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Nombre *</label>
                            <input type="text" name="nombre"
                                   value="{{ old('nombre', $deudor->nombre) }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('nombre')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Apellido *</label>
                            <input type="text" name="apellido"
                                   value="{{ old('apellido', $deudor->apellido) }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('apellido')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $deudor->email) }}"
                                   class="w-full border rounded px-3 py-2">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Teléfono</label>
                            <input type="text" name="telefono"
                                   value="{{ old('telefono', $deudor->telefono) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Dirección</label>
                            <input type="text" name="direccion"
                                   value="{{ old('direccion', $deudor->direccion) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Notas</label>
                            <textarea name="notas" rows="3"
                                      class="w-full border rounded px-3 py-2">{{ old('notas', $deudor->notas) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('deudores.show', $deudor) }}"
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