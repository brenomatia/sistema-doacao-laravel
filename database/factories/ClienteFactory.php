<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        $dataMesPassado = \Carbon\Carbon::now()->subMonth();
        $mesatual = now();

        return [
            'name' => $this->faker->name,
            'rua' => 'c' . $this->faker->numberBetween(10, 99), // Gera um número aleatório entre 10 e 99
            'numero' => $this->faker->numberBetween(100, 999), // Gera um número aleatório entre 100 e 999
            'celular' => $this->faker->numberBetween(10000000000, 99999999999), // Gera um número aleatório de 11 dígitos
            'bairro' => 'UNIVERSAL',
            'cidade' => 'ituiutaba-MG',
            'doador' => '',
            'tipo' => 'SAE',
            'valor' => $this->faker->randomFloat(2, 0, 100), // Gera um número decimal entre 0 e 100
            'situacao' => '',
            'tipo_pagamento' => 'MENSAL',
            'created_at' => $mesatual,
            'updated_at' => $mesatual,
        ];
    }
}