<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_ibge')->nullable();
            $table->string('nome', 255);
            $table->timestamps();
            $table->string('cod_uf', 255)->nullable();
        });

        // Adiciona o comentário à tabela
        DB::statement('COMMENT ON TABLE municipios IS \'Tabela de municípios segundo o IBGE - FIXA\'');

        // Altera a coluna 'cod_uf' para ser nullable
        Schema::table('municipios', function (Blueprint $table) {
            $table->string('cod_uf', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipios');
    }
}
