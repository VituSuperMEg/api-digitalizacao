<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->smallInteger('porte_empresa');
            $table->smallInteger('fpas_id');
            $table->smallInteger('natureza_juridica_id');
            $table->smallInteger('cnae_id');
            $table->smallInteger('simples');
            $table->integer('cargo_gestor_id')->nullable();
            $table->integer('numero_endereco')->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('complemento', 255)->nullable();
            $table->string('bairro', 255)->nullable();
            $table->string('telefone', 13)->nullable();
            $table->integer('municipio_id');
            $table->string('email', 255)->nullable();
            $table->string('site', 255)->nullable();
            $table->integer('logradouro_tipo_id')->nullable();
            $table->string('nome_gestor')->default('INFORMAR NOME DO GESTOR');
            $table->boolean('contrib_substitutiva');
            $table->string('cnpj', 14)->default('0');
            $table->integer('criado_por')->nullable();
            $table->integer('alterado_por')->nullable();
            $table->timestamp('criado_em')->nullable();
            $table->timestamp('alterado_em')->nullable();
            $table->string('cep', 8)->default('00000000');
            $table->string('cod_mun_tcm', 3)->nullable();
            $table->string('nome_instituto_rpps', 60)->nullable();
            $table->integer('cod_pag_gps')->nullable();
            $table->string('logo_instituto_rpps', 500)->nullable();
            $table->string('logo_entidade', 500)->nullable();
            $table->boolean('inf_tcm')->nullable();
            $table->integer('proc_adm_jud_fap_id')->nullable();
            $table->string('nome_contato', 60)->nullable();
            $table->string('cpf_contato', 11)->nullable();
            $table->string('fone_contato', 13)->nullable();
            $table->string('cel_contato', 13)->nullable();
            $table->boolean('ind_rpps')->default(0);
            $table->string('nr_siafi', 6)->nullable();
            $table->integer('classificacao_tributaria_id')->default(17);
            $table->string('cod_municipio_aspec', 4)->nullable();
            $table->string('cod_entidade_aspec', 3)->nullable();
            $table->string('nmente')->nullable();
            $table->string('cnpjefr', 14)->nullable();
            $table->integer('tipo_entidade')->nullable();
            $table->integer('qtde_vereadores')->nullable();
            $table->smallInteger('subteto')->nullable();
            $table->decimal('vrsubteto', 10, 2)->nullable();
            $table->boolean('esocial')->default(0);
            $table->smallInteger('regpt')->nullable();
            $table->smallInteger('contapr')->nullable();
            $table->string('nrprocjud_apr', 20)->nullable();
            $table->boolean('contented_apr')->nullable();
            $table->smallInteger('contpcd')->nullable();
            $table->string('nrprocjud_pcd', 20)->nullable();
            $table->boolean('ideefr')->nullable();
            $table->smallInteger('recolhimento_sefip')->default(115);
            $table->string('entidade_relatorio', 120)->nullable();
            $table->boolean('entidade_sefip_header')->nullable();
            $table->smallInteger('ind_cooperativa')->default(0);
            $table->boolean('indugrpps')->nullable();
            $table->boolean('prev_comp')->nullable();
            $table->smallInteger('esferaop')->nullable();
            $table->smallInteger('poderop')->nullable();
            $table->decimal('vrtetorem', 10, 2)->nullable();
            $table->string('cnpjenteduc', 14)->nullable();
            $table->string('tomticket_cliente_id', 200)->nullable();
            $table->string('cod_mun_econtas', 20)->nullable();
            $table->integer('orgao_mun_econtas_id')->nullable();
            $table->boolean('ind_construtora')->nullable();
            $table->smallInteger('ind_des_folha')->nullable();
            $table->integer('entidade_tcnj_id')->nullable();
            $table->string('codigo_cliente', 9)->nullable();
            $table->string('maquina_id', 45)->nullable();
            $table->date('data_expiracao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entidades');
    }
}
