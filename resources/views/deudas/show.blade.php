<x-app-layout>
    <x-slot name="title">
        Deuda: {{ $deuda->descripcion ?? 'Sin descripción' }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Deuda: {{ $deuda->descripcion ?? 'Sin descripción' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif --}}

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Detalles de la deuda</h3>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-gray-500 text-sm">Deudor</dt>
                            <dd class="font-medium">
                                <a href="{{ route('deudores.show', $deuda->deudor) }}"
                                   class="text-blue-600 hover:underline">
                                    {{ $deuda->deudor->nombre }} {{ $deuda->deudor->apellido }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Estado</dt>
                            <dd class="font-medium">
                                <x-estado-badge :estado="$deuda->estado" />
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Monto total</dt>
                            <dd class="font-medium">${{ number_format($deuda->monto_total, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Monto pagado</dt>
                            <dd class="font-medium">${{ number_format($deuda->monto_pagado, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Saldo pendiente</dt>
                            <dd class="font-semibold text-lg">${{ number_format($deuda->saldoPendiente(), 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Vencimiento</dt>
                            <dd class="font-medium">
                                {{ $deuda->fecha_vencimiento ? $deuda->fecha_vencimiento->format('d/m/Y') : '—' }}
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('deudas.edit', $deuda) }}"
                           class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Editar
                        </a>

                        <form method="POST" action="{{ route('deudas.destroy', $deuda) }}"
                              onsubmit="return confirm('¿Eliminar esta deuda ({{ $deuda->descripcion ?? 'Sin descripción' }}) de {{ $deuda->deudor->nombre }}? Se eliminarán también sus pagos registrados.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Eliminar
                            </button>
                        </form>

                        <a href="{{ route('deudores.show', $deuda->deudor) }}"
                           class="px-4 py-2 border rounded">Volver al deudor</a>
                    </div>
                </div>
            </div>

            {{-- Formulario para registrar pago --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Registrar pago</h3>

                    @if ($deuda->estaPagada())
                        <p class="text-green-700 font-medium">
                            ✓ Esta deuda está completamente pagada.
                        </p>
                    @else
                        <form method="POST" action="{{ route('pagos.store', $deuda) }}">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block font-medium mb-1">Monto *</label>
                                    <input type="number" step="0.01" min="0.01"
                                        max="{{ $deuda->saldoPendiente() }}"
                                        name="monto" value="{{ old('monto') }}"
                                        class="w-full border rounded px-3 py-2">
                                    @error('monto')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Fecha de pago *</label>
                                    <input type="date" name="fecha_pago"
                                        value="{{ old('fecha_pago', now()->format('Y-m-d')) }}"
                                        class="w-full border rounded px-3 py-2">
                                    @error('fecha_pago')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Notas</label>
                                    <input type="text" name="notas" value="{{ old('notas') }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>
                            </div>

                            <div class="mt-4 flex justify-between items-center">
                                <p class="text-gray-600">
                                    Saldo pendiente:
                                    <strong>${{ number_format($deuda->saldoPendiente(), 2) }}</strong>
                                </p>
                                <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Registrar Pago
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Historial de pagos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Historial de pagos</h3>

                    @if ($deuda->pagos->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Sin pagos registrados</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if ($deuda->estaPagada())
                                    Esta deuda está marcada como pagada, pero no tiene pagos registrados.
                                @else
                                    Usa el formulario de arriba para registrar el primer pago.
                                @endif
                            </p>
                        </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left">
                                    <th class="px-4 py-2">Fecha</th>
                                    <th class="px-4 py-2">Monto</th>
                                    <th class="px-4 py-2">Notas</th>
                                    <th class="px-4 py-2 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deuda->pagos->sortByDesc('fecha_pago') as $pago)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">${{ number_format($pago->monto, 2) }}</td>
                                        <td class="px-4 py-2">{{ $pago->notas ?? '—' }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <form method="POST" action="{{ route('pagos.destroy', $pago) }}"
                                                onsubmit="return confirm('¿Eliminar el pago de ${{ number_format($pago->monto, 2) }} del {{ $pago->fecha_pago->format('d/m/Y') }}? El saldo de la deuda se recalculará.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>