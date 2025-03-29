<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadeEnderecosTable extends Migration

{
    public function up()
    {
        Schema::create('unidade_endereco', function (Blueprint $table) {
            $table->bigIncrements('cid_id');
            $table->string('cid_nome', 200);
            $table->string('cid_uf', 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cidades');
    }
}
