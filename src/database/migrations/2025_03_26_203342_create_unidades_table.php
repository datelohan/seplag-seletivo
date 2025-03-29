<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadesTable extends Migration
{
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->bigIncrements('uni_id');
            $table->string('uni_sigla', 50);
            $table->string('uni_nome', 200);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidades');
    }
}
