<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoaEnderecosTable extends Migration
{
    public function up()
    {
        Schema::create('pessoa_enderecos', function (Blueprint $table) {
            $table->unsignedBigInteger('pes_id');
            $table->unsignedBigInteger('end_id');

            $table->foreign('pes_id')->references('pes_id')->on('pessoas');
            $table->foreign('end_id')->references('end_id')->on('enderecos');

            // Se quiser evitar duplicidades na combinação:
            $table->primary(['pes_id', 'end_id']);

            // Se precisar de colunas extras (por exemplo, "tipo_endereco"), adicione aqui
        });
    }

    public function down()
    {
        Schema::dropIfExists('pessoa_enderecos');
    }
}
