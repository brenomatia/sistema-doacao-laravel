<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emaberto', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor', 10, 2);
            $table->string('nome_cliente')->nullable();
            $table->string('gerou_recibo_id')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->string('end_cliente')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emaberto');
    }
};