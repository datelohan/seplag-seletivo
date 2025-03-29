<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('unidade_endereco', function (Blueprint $table) {
            // Remove a chave primária existente, se houver
          

            // Adiciona a coluna 'id' como chave primária auto-incrementada
            

            // Adiciona a coluna 'unid_id' como chave estrangeira para a tabela 'unidades'
            $table->unsignedBigInteger('unid_id')->nullable()->after('id');
            $table->foreign('unid_id')->references('uni_id')->on('unidades')->onDelete('cascade');

            // Adiciona a coluna 'end_id' como chave estrangeira para a tabela 'enderecos'
            $table->unsignedBigInteger('end_id')->nullable()->after('unid_id');
            $table->foreign('end_id')->references('end_id')->on('enderecos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('unidade_endereco', function (Blueprint $table) {
            // Remove as chaves estrangeiras e as colunas
            $table->dropForeign(['unid_id']);
            $table->dropColumn('unid_id');

            $table->dropForeign(['end_id']);
            $table->dropColumn('end_id');

            $table->dropColumn('id');
        });
    }
};
