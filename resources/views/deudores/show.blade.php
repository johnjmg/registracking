<x-app-layout>
    <x-slot name="title">
        {{ $deudor->nombre }} {{ $deudor->apellido }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $deudor->nombre }} {{ $deudor->apellido }}
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
                    <h3 class="text-lg font-semibold mb-4">Información del deudor</h3>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-gray-500 text-sm">Email</dt>
                            <dd class="font-medium">{{ $deudor->email ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm">Teléfono</dt>
                            <dd class="font-medium">{{ $deudor->telefono ?? '—' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500 text-sm">Dirección</dt>
                            <dd class="font-medium">{{ $deudor->direccion ?? '—' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500 text-sm">Notas</dt>
                            <dd class="font-medium">{{ $deudor->notas ?? '—' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('deudores.edit', $deudor) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Editar
                        </a>

                        <form method="POST" action="{{ route('deudores.destroy', $deudor) }}"
                            onsubmit="return confirm('¿Eliminar a {{ $deudor->nombre }} {{ $deudor->apellido }}? Se eliminarán también todas sus deudas y pagos. Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Eliminar
                            </button>
                        </form>

                        <a href="{{ route('deudores.index') }}"
                        class="px-4 py-2 border rounded">Volver</a>
                    </div>
                </div>
            </div>

            {{-- Sección de deudas --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Deudas</h3>
                        <a href="{{ route('deudas.create', ['deudor_id' => $deudor->id]) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Agregar Deuda
                        </a>
                    </div>

                    @if ($deudor->deudas->isEmpty())
                        <p class="text-gray-500">Este deudor no tiene deudas registradas.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left">
                                    <th class="px-4 py-2">Descripción</th>
                                    <th class="px-4 py-2">Monto total</th>
                                    <th class="px-4 py-2">Pagado</th>
                                    <th class="px-4 py-2">Saldo</th>
                                    <th class="px-4 py-2">Estado</th>
                                    <th class="px-4 py-2">Vence</th>
                                    <th class="px-4 py-2 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deudor->deudas as $deuda)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $deuda->descripcion ?? '—' }}</td>
                                        <td class="px-4 py-2">${{ number_format($deuda->monto_total, 2) }}</td>
                                        <td class="px-4 py-2">${{ number_format($deuda->monto_pagado, 2) }}</td>
                                        <td class="px-4 py-2 font-semibold">${{ number_format($deuda->saldoPendiente(), 2) }}</td>
                                        <td class="px-4 py-2">
                                            <x-estado-badge :estado="$deuda->estado" />
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ $deuda->fecha_vencimiento ? $deuda->fecha_vencimiento->format('d/m/Y') : '—' }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            <a href="{{ route('deudas.show', $deuda) }}"
                                            class="text-blue-600 hover:underline">Ver</a>
                                            <a href="{{ route('deudas.edit', $deuda) }}"
                                            class="ml-2 text-yellow-600 hover:underline">Editar</a>
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