<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Adicione esta linha

return new class extends Migration
{
    public function up()
    {
        Schema::table('fotos_pessoas', function (Blueprint $table) {
            // Apagar a coluna fot_data
            $table->dropColumn('fot_data');
        });

        Schema::table('fotos_pessoas', function (Blueprint $table) {
            // Alterar o tipo da coluna fp_data para date usando SQL bruto
            DB::statement('ALTER TABLE fotos_pessoas ALTER COLUMN fp_data TYPE DATE USING fp_data::DATE');
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
            // Reverter a alteração do tipo da coluna fp_data para o tipo original (string)
            $table->string('fp_data')->change();

            // Recriar a coluna fot_data como string
            $table->string('fot_data')->nullable();
        });
    }
};