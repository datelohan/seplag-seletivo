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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id'); // Chave primária
            $table->string('tokenable_type'); // Tipo do modelo relacionado
            $table->unsignedBigInteger('tokenable_id'); // ID do modelo relacionado
            $table->string('name'); // Nome do token
            $table->string('token', 64)->unique(); // Token único
            $table->text('abilities')->nullable(); // Permissões associadas ao token
            $table->timestamp('last_used_at')->nullable(); // Última utilização do token
            $table->timestamp('expires_at')->nullable(); // Expiração do token
            $table->timestamps(); // Campos created_at e updated_at

            $table->index(['tokenable_type', 'tokenable_id']); // Índice para consultas polimórficas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
