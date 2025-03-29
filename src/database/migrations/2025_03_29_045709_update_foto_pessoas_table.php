<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fotos_pessoas', function (Blueprint $table) {
            // Renomear colunas existentes
            $table->renameColumn('fot_id', 'fp_id');
            $table->renameColumn('pes_id', 'fp_pes_id');
            $table->renameColumn('fot_busca', 'fp_data');

            // Adicionar novas colunas
            $table->string('fp_bucket', 50)->nullable();
            $table->string('fp_hash', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fotos_pessoas', function (Blueprint $table) {
            // Reverter renomeação de colunas
            $table->renameColumn('fp_id', 'fot_id');
            $table->renameColumn('fp_pes_id', 'pes_id');
            $table->renameColumn('fp_data', 'fot_busca');

            // Remover as colunas adicionadas
            $table->dropColumn('fp_bucket');
            $table->dropColumn('fp_hash');
        });
    }
};
