<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lotacaos', function (Blueprint $table) {
            // Adiciona a coluna 'pes_id' como chave estrangeira para a tabela 'pessoas'
            $table->unsignedBigInteger('pes_id')->nullable()->after('lot_id');
            $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('cascade');

            // Renomeia as colunas existentes
            $table->renameColumn('lot_data_inicial', 'lot_data_lotacao');
            $table->renameColumn('lot_data_final', 'lot_data_remocao');

            // Adiciona a nova coluna 'lot_portaria'
            $table->string('lot_portaria', 255)->nullable()->after('lot_data_remocao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('lotacaos', function (Blueprint $table) {
            // Remove a coluna 'pes_id' e sua chave estrangeira
            $table->dropForeign(['pes_id']);
            $table->dropColumn('pes_id');

            // Reverte os nomes das colunas
            $table->renameColumn('lot_data_lotacao', 'lot_data_inicial');
            $table->renameColumn('lot_data_remocao', 'lot_data_final');

            // Remove a coluna 'lot_portaria'
            $table->dropColumn('lot_portaria');
        });
    }
};
