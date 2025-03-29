<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosPessoasTable extends Migration
{
    public function up()
    {
        Schema::create('fotos_pessoas', function (Blueprint $table) {
            $table->bigIncrements('fot_id');
            // FK para pessoa
            $table->unsignedBigInteger('pes_id');
            $table->foreign('pes_id')->references('pes_id')->on('pessoas');

            // Exemplo de colunas adicionais
            $table->date('fot_data')->nullable();
            $table->string('fot_busca', 255)->nullable(); // Ajuste conforme necessidade

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fotos_pessoas');
    }
}
