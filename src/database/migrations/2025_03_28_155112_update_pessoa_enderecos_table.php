<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pessoa_enderecos', function (Blueprint $table) {
   
            $table->timestamps(); // Cria os campos 'created_at' e 'updated_at'

       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pessoa_enderecos');
    }
};
