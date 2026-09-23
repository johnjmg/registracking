<x-app-layout>
    <x-slot name="title">
        Deudores
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Deudores
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif --}}

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
                        <h3 class="text-lg font-semibold">Listado de deudores</h3>

                        <form method="GET" action="{{ route('deudores.index') }}" class="flex gap-2">
                            <input type="text" name="q" value="{{ $busqueda }}"
                                placeholder="Buscar por nombre, email, teléfono..."
                                class="border rounded px-3 py-2 w-72">
                            <button type="submit"
                                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                Buscar
                            </button>
                            @if ($busqueda)
                                <a href="{{ route('deudores.index') }}"
                                class="px-4 py-2 border rounded hover:bg-gray-100">
                                    Limpiar
                                </a>
                            @endif
                        </form>

                        <a href="{{ route('deudores.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Nuevo Deudor
                        </a>
                    </div>


                    @if ($deudores->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">
                                @if ($busqueda)
                                    Sin resultados
                                @else
                                    No hay deudores
                                @endif
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if ($busqueda)
                                    No se encontraron deudores que coincidan con "{{ $busqueda }}".
                                @else
                                    Comienza registrando a tu primer deudor.
                                @endif
                            </p>
                            @unless ($busqueda)
                                <div class="mt-6">
                                    <a href="{{ route('deudores.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        + Nuevo Deudor
                                    </a>
                                </div>
                            @endunless
                        </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left">
                                    <th class="px-4 py-2">Nombre</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Teléfono</th>
                                    <th class="px-4 py-2 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deudores as $deudor)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">
                                            {{ $deudor->nombre }} {{ $deudor->apellido }}
                                        </td>
                                        <td class="px-4 py-2">{{ $deudor->email ?? '—' }}</td>
                                        <td class="px-4 py-2">{{ $deudor->telefono ?? '—' }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <a href="{{ route('deudores.show', $deudor) }}"
                                               class="text-blue-600 hover:underline">Ver</a>
                                            <a href="{{ route('deudores.edit', $deudor) }}"
                                               class="ml-2 text-yellow-600 hover:underline">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        <div class="mt-4">
                            {{ $deudores->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>