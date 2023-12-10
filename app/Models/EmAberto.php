<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmAberto extends Model
{
    protected $table = 'emaberto';
    protected $primaryKey = 'id';

    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'valor',
        'nome_cliente',
        'end_cliente',
        'status',
    ];
}