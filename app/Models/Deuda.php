<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    use HasFactory;

    protected $table = 'deudas';

    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PARCIAL = 'pagado_parcial';
    const ESTADO_PAGADO = 'pagado_total';

    protected $fillable = [
        'deudor_id',
        'descripcion',
        'monto_total',
        'monto_pagado',
        'fecha_vencimiento',
        'estado',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'monto_total' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
    ];

    // Relaciones
    public function deudor()
    {
        return $this->belongsTo(Deudor::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    // Métodos de utilidad
    public function saldoPendiente(): float
    {
        return (float) $this->monto_total - (float) $this->monto_pagado;
    }

    public function estaPagada(): bool
    {
        return $this->estado === self::ESTADO_PAGADO;
    }

    public function actualizarEstado(): void
    {
        if ($this->monto_pagado <= 0) {
            $this->estado = self::ESTADO_PENDIENTE;
        } elseif ($this->monto_pagado >= $this->monto_total) {
            $this->estado = self::ESTADO_PAGADO;
        } else {
            $this->estado = self::ESTADO_PARCIAL;
        }
        $this->save();
    }
    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', '!=', self::ESTADO_PAGADO);
    }

    public function scopeVencidas($query)
    {
        return $query->pendientes()
                    ->whereNotNull('fecha_vencimiento')
                    ->whereDate('fecha_vencimiento', '<', now());
    }

    public function scopeProximasAVencer($query, $dias = 7)
    {
        return $query->pendientes()
                    ->whereNotNull('fecha_vencimiento')
                    ->whereDate('fecha_vencimiento', '>=', now())
                    ->whereDate('fecha_vencimiento', '<=', now()->addDays($dias));
    }
}