<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pessoa_enderecos', function (Blueprint $table) {
            // Remove as chaves estrangeiras relacionadas
            $table->dropForeign(['pes_id']);
            $table->dropForeign(['end_id']);

            // Remove a chave primária composta
            $table->dropPrimary(['pes_id', 'end_id']);

            // Adiciona a nova coluna 'id' como chave primária
            $table->id()->first();

            // Recria as chaves estrangeiras
            $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('cascade');
            $table->foreign('end_id')->references('end_id')->on('enderecos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pessoa_enderecos', function (Blueprint $table) {
            // Remove a coluna 'id'
            $table->dropColumn('id');

            // Remove as chaves estrangeiras recriadas
            $table->dropForeign(['pes_id']);
            $table->dropForeign(['end_id']);

            // Restaura a chave primária composta
            $table->primary(['pes_id', 'end_id']);

            // Recria as chaves estrangeiras originais
            $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('cascade');
            $table->foreign('end_id')->references('end_id')->on('enderecos')->onDelete('cascade');
        });
    }
};
