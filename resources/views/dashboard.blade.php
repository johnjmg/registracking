<x-app-layout>
    <x-slot name="title">
        Panel de Control
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Control
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tarjetas de resumen --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500 text-sm">Deudores</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalDeudores }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500 text-sm">Total adeudado</p>
                    <p class="text-3xl font-bold text-red-600">${{ number_format($totalAdeudado, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500 text-sm">Total recuperado</p>
                    <p class="text-3xl font-bold text-green-600">${{ number_format($totalPagado, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-gray-500 text-sm">Deudas pendientes</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $deudasPendientes }}</p>
                </div>
            </div>

            {{-- Alertas --}}
            @if ($deudasVencidas->isNotEmpty())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <h3 class="font-semibold text-red-800 mb-2">
                        ⚠ Deudas vencidas ({{ $deudasVencidas->count() }})
                    </h3>
                    <ul class="divide-y divide-red-200">
                        @foreach ($deudasVencidas as $deuda)
                            <li class="py-2 flex justify-between items-center">
                                <div>
                                    <a href="{{ route('deudas.show', $deuda) }}"
                                       class="font-medium text-red-800 hover:underline">
                                        {{ $deuda->deudor->nombre }} {{ $deuda->deudor->apellido }}
                                    </a>
                                    <span class="text-red-600 text-sm">
                                        — {{ $deuda->descripcion ?? 'Sin descripción' }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">${{ number_format($deuda->saldoPendiente(), 2) }}</p>
                                    <p class="text-xs text-red-600">
                                        Venció el {{ $deuda->fecha_vencimiento->format('d/m/Y') }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($deudasProximas->isNotEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                    <h3 class="font-semibold text-yellow-800 mb-2">
                        ⏰ Próximas a vencer (7 días)
                    </h3>
                    <ul class="divide-y divide-yellow-200">
                        @foreach ($deudasProximas as $deuda)
                            <li class="py-2 flex justify-between items-center">
                                <div>
                                    <a href="{{ route('deudas.show', $deuda) }}"
                                       class="font-medium text-yellow-800 hover:underline">
                                        {{ $deuda->deudor->nombre }} {{ $deuda->deudor->apellido }}
                                    </a>
                                    <span class="text-yellow-700 text-sm">
                                        — {{ $deuda->descripcion ?? 'Sin descripción' }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">${{ number_format($deuda->saldoPendiente(), 2) }}</p>
                                    <p class="text-xs text-yellow-700">
                                        Vence el {{ $deuda->fecha_vencimiento->format('d/m/Y') }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Deudas recientes --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Deudas pendientes recientes</h3>
                        <a href="{{ route('deudas.index') }}"
                           class="text-blue-600 hover:underline text-sm">
                            Ver todas →
                        </a>
                    </div>

                    @if ($deudasRecientes->isEmpty())
                        <p class="text-gray-500">
                            No tienes deudas pendientes. ¡Buen trabajo!
                        </p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left">
                                    <th class="px-4 py-2">Deudor</th>
                                    <th class="px-4 py-2">Descripción</th>
                                    <th class="px-4 py-2">Saldo</th>
                                    <th class="px-4 py-2">Vence</th>
                                    <th class="px-4 py-2 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deudasRecientes as $deuda)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">
                                            <a href="{{ route('deudores.show', $deuda->deudor) }}"
                                               class="text-blue-600 hover:underline">
                                                {{ $deuda->deudor->nombre }} {{ $deuda->deudor->apellido }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-2">{{ $deuda->descripcion ?? '—' }}</td>
                                        <td class="px-4 py-2 font-semibold">
                                            ${{ number_format($deuda->saldoPendiente(), 2) }}
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
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>