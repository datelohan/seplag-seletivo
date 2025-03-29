<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServidorTemporariosTable extends Migration
{
    public function up()
    {
        Schema::create('servidor_temporarios', function (Blueprint $table) {
            $table->bigIncrements('ser_id');
            // FK para pessoa
            $table->unsignedBigInteger('pes_id');
            $table->foreign('pes_id')->references('pes_id')->on('pessoas');

            $table->date('ser_data_admissao')->nullable();
            $table->date('ser_data_demissao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servidor_temporarios');
    }
}
