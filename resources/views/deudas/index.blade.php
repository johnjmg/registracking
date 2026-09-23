<x-app-layout>
    <x-slot name="title">
        Todas las Deudas
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Todas las Deudas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                <form method="GET" action="{{ route('deudas.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Buscar deudor</label>
                    <input type="text" name="q" value="{{ $busqueda }}"
                        placeholder="Nombre o apellido"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Estado</label>
                    <select name="estado" class="w-full border rounded px-3 py-2">
                        <option value="">Todos</option>
                        <option value="pendiente" @selected($estado === 'pendiente')>Pendiente</option>
                        <option value="pagado_parcial" @selected($estado === 'pagado_parcial')>Parcial</option>
                        <option value="pagado_total" @selected($estado === 'pagado_total')>Pagado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Vencimiento</label>
                    <select name="vencimiento" class="w-full border rounded px-3 py-2">
                        <option value="">Todos</option>
                        <option value="vencidas" @selected($vencimiento === 'vencidas')>Vencidas</option>
                        <option value="proximas" @selected($vencimiento === 'proximas')>Próximas 7 días</option>
                        <option value="sin_vencimiento" @selected($vencimiento === 'sin_vencimiento')>Sin vencimiento</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Filtrar
                    </button>
                    @if ($busqueda || $estado || $vencimiento)
                        <a href="{{ route('deudas.index') }}"
                        class="px-4 py-2 border rounded hover:bg-gray-100">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>

                    @if ($deudas->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">
                                @if ($busqueda || $estado || $vencimiento)
                                    Sin resultados
                                @else
                                    No hay deudas
                                @endif
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if ($busqueda || $estado || $vencimiento)
                                    No se encontraron deudas con los filtros aplicados.
                                @else
                                    Las deudas se crean desde la ficha de cada deudor.
                                @endif
                            </p>
                            @unless ($busqueda || $estado || $vencimiento)
                                <div class="mt-6">
                                    <a href="{{ route('deudores.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Ir a Deudores
                                    </a>
                                </div>
                            @endunless
                        </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left">
                                    <th class="px-4 py-2">Deudor</th>
                                    <th class="px-4 py-2">Descripción</th>
                                    <th class="px-4 py-2">Saldo</th>
                                    <th class="px-4 py-2">Estado</th>
                                    <th class="px-4 py-2">Vence</th>
                                    <th class="px-4 py-2 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deudas as $deuda)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">
                                            {{ $deuda->deudor->nombre }} {{ $deuda->deudor->apellido }}
                                        </td>
                                        <td class="px-4 py-2">{{ $deuda->descripcion ?? '—' }}</td>
                                        <td class="px-4 py-2 font-semibold">
                                            ${{ number_format($deuda->saldoPendiente(), 2) }}
                                        </td>
                                        <td class="px-4 py-2">
                                            <x-estado-badge :estado="$deuda->estado" />
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ $deuda->fecha_vencimiento ? $deuda->fecha_vencimiento->format('d/m/Y') : '—' }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            <a href="{{ route('deudas.show', $deuda) }}"
                                               class="text-blue-600 hover:underline">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                        <div class="mt-4">
                            {{ $deudas->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>