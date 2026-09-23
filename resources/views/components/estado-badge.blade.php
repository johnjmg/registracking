@props(['estado'])

@php
    $config = match ($estado) {
        'pagado_total' => ['bg-green-100 text-green-800', 'Pagado'],
        'pagado_parcial' => ['bg-yellow-100 text-yellow-800', 'Parcial'],
        'pendiente' => ['bg-red-100 text-red-800', 'Pendiente'],
        default => ['bg-gray-100 text-gray-800', $estado],
    };
@endphp

<span {{ $attributes->merge(['class' => "px-2 py-1 rounded text-xs font-medium {$config[0]}"]) }}>
    {{ $config[1] }}
</span>