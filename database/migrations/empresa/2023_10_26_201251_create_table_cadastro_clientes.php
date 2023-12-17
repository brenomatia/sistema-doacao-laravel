<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('registro_id')->nullable();
            $table->string('name')->nullable()->unique();
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('celular')->nullable();
            $table->string('telefone_fixo')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('doador')->nullable();
            $table->string('tipo')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->string('situacao')->nullable();
            $table->string('tipo_pagamento')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};