<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('servidor_efetivos', function (Blueprint $table) {
            // Remove a coluna 'ser_data_admissao'
            $table->dropColumn('ser_data_admissao');

            // Adiciona a coluna 'se_matricula'
            $table->string('se_matricula', 50)->nullable()->after('pes_id');

            // Ajusta a referência para 'pes_id'
            // $table->foreign('pes_id')->references('pes_id')->on('pessoas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('servidor_efetivos', function (Blueprint $table) {
            // Reverte a remoção da coluna 'ser_data_admissao'
            $table->date('ser_data_admissao')->nullable()->after('pes_id');

            // Remove a coluna 'se_matricula'
            $table->dropColumn('se_matricula');

            // Remove a referência para 'pes_id'
            $table->dropForeign(['pes_id']);
        });
    }
};
