<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';

    use HasFactory;
    protected $fillable = [
        'name',
        'rua',
        'numero',
        'celular',
        'valor',
        'bairro',
        'horario_receber',
        'data_receber',
        'cidade',
        'cep',
        'situacao',
        'data_avencer',
        'tipo_pagamento',
    ];

    public function doacoes()
    {
        return $this->hasMany(Doacao::class, 'cliente_id');
    }
}