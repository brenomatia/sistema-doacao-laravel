<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod extends Model
{
    protected $table = 'empresa_logs';
    protected $primaryKey = 'id';

    use HasFactory;

    protected $fillable = [
        'name',
        'tipo',
        'cliente_id',
        'registro_acao',
    ];

}