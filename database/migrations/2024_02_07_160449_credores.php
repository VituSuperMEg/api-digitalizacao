<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Credores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credores', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable(false)->unique();
            $table->string('tipo_documento')->nullable(false);
            $table->string('cpf', 11)->nullable(false)->unique();
            $table->string('logradouro')->nullable(false);
            $table->string('numero')->nullable(false);
            $table->string('bairro')->nullable(false);
            $table->string('cep', 15)->nullable(false);
            $table->string('e-mail', 255)->nullable(false);
            $table->string('cidade')->nullable(false);
            $table->string('telefone');
            $table->string('telefone_complementar');
            $table->string('banco');
            $table->string('agencia');
            $table->string('conta');
            $table->string('observacoes', 255);
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
