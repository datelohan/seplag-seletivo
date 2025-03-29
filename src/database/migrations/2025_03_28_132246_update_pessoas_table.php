<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pessoas', function (Blueprint $table) {
            $table->string('pes_sexo', 20)->nullable()->after('pes_data_nascimento'); // Adiciona a coluna 'pes_sexo'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pessoas', function (Blueprint $table) {
            $table->dropColumn('pes_sexo'); // Remove a coluna 'pes_sexo'
        });
    }
};
