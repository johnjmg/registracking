<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deudor extends Model
{
    use HasFactory;

    protected $table = 'deudores';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'notas',
    ];

    // Definir los tipos de datos de los atributos, quiero que user_id sea un entero
    protected $casts = [
    'user_id' => 'integer',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deudas()
    {
        return $this->hasMany(Deuda::class);
    }
}