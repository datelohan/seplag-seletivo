<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->bigIncrements('end_id');
            $table->string('end_tipo_logradouro', 50)->nullable();
            $table->string('end_logradouro', 200);
            $table->string('end_numero', 20)->nullable();
            // Se existir bairro, complemento, CEP, etc., adicione aqui

            // FK para cidades
            $table->unsignedBigInteger('cid_id')->nullable();
            $table->foreign('cid_id')->references('cid_id')->on('cidades');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
