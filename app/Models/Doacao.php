<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doacao extends Model
{

    protected $table = 'doacoes';
    protected $primaryKey = 'id';

    use HasFactory;

    protected $fillable = [
        'id_cliente',
        'valor',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

}