<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Cliente::factory(30)->create();

        // Usando a UserFactory para criar uma instância de Cliente
        \App\Models\Cliente::factory()->create([
            'name' => 'User teste',
            'rua' => 'c11',
            'numero' => '124',
            'celular' => '34997995401',
            'bairro' => 'cannã 2',
            'cidade' => 'ituiutaba-MG',
            'doador' => '',
            'tipo' => 'SAE',
            'valor' => '5',
            'situacao' => '',
            'tipo_pagamento' => 'MENSAL',
        ]);
    }
}