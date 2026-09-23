<x-app-layout>
    <x-slot name="title">Nuevo Deudor</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Deudor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('deudores.store') }}">
                        @csrf

                        <x-form-input name="nombre" label="Nombre" :required="true" />
                        <x-form-input name="apellido" label="Apellido" :required="true" />
                        <x-form-input name="email" type="email" label="Email" />
                        <x-form-input name="telefono" label="Teléfono" />
                        <x-form-input name="direccion" label="Dirección" />

                        <div class="mb-4">
                            <label for="notas" class="block font-medium mb-1 text-gray-700">Notas</label>
                            <textarea name="notas" id="notas" rows="3"
                                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notas') }}</textarea>
                            @error('notas')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('deudores.index') }}"
                               class="px-4 py-2 border rounded hover:bg-gray-100">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Guardar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>