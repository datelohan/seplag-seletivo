<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotacaosTable extends Migration
{
    public function up()
    {
        Schema::create('lotacaos', function (Blueprint $table) {
            $table->bigIncrements('lot_id');

            // FK para unidade
            $table->unsignedBigInteger('uni_id');
            $table->foreign('uni_id')->references('uni_id')->on('unidades');

            // Exemplo de datas
            $table->date('lot_data_inicial')->nullable();
            $table->date('lot_data_final')->nullable();

            // Se existir outra referência (por exemplo, servidor), adicione:
            // $table->unsignedBigInteger('ser_id')->nullable();
            // $table->foreign('ser_id')->references('ser_id')->on('servidor_efetivos'); (ou temporários)

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lotacaos');
    }
}
