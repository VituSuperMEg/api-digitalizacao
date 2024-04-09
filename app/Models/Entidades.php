<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidades extends Model
{
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.entidades';
    protected $fillable = [
        "id",
        "razao_social",
        "porte_empresa",
        "fpas_id",
        "natureza_juridica_id",
        "cnae_id",
        "simples",
        "cargo_gestor_id",
        "numero_endereco",
        "endereco",
        "complemento",
        "bairro",
        "telefone",
        "municipio_id",
        "email",
        "site",
        "created_at",
        "updated_at",
        "logradouro_tipo_id",
        "nome_gestor",
        "contrib_substitutiva",
        "cnpj",
        "cep",
        "cod_mun_tcm",
        "nome_instituto_rpps",
        "cod_pag_gps",
        "logo_instituto_rpps",
        "logo_entidade",
        "inf_tcm d_binario",
        "proc_adm_jud_fap_id",
        "nome_contato",
        "cpf_contato",
        "fone_contato",
        "cel_contato",
        "nr_siafi",
        "classificacao_tributaria_id",
        "cod_municipio_aspec",
        "cod_entidade_aspec",
        "nmente",
        "cnpjefr",
        "tipo_entidade",
        "qtde_vereadores",
        "subteto",
        "vrsubteto",
        "esocial",
        "regpt",
        "contapr",
        "nrprocjud_apr",
        "contented",
        "contpcd",
        "nrprocjud_pcd",
        "ideefr",
        "recolhimento_sefip",
        "entidade_relatorio",
        "entidade_sefip_header",
        "ind_cooperativa",
        "indugrpps",
        "esferaop",
        "poderop",
        "vrtetorem",
        "cnpjenteduc",
        "prev_comp",
        "ind_rpps",
        "criado_por",
        "alterado_por",
        "criado_em",
        "alterado_em",
    ];

    public function municipio(){
        return $this->belongsTo(Municipios::class, 'municipio_id');
    }

    public static function getIdEntidadeByIbge($cliente = CLIENTE) {

        $idEntidades = array(
            //Jucas
            '230740301' => 76, // PREFEITURA
            //Iguatu
            '230550601' => 76, // Prefeitura
            '230550603' => 76, // SAAE
            '230550607' => 76, // POLICLINICA
            '230550608' => 76, // HOSPITAL REGIONAL
            '230550609' => 76, // CENTRO DE NEFROLOGIA
            //Barbalha
            '230190101' => 76, // PREFEITURA
            //NOVA OLINDA
            '230920101' => 76, // PREFEITRA,
            //CHOROZINHO
            '230395601' => 76, // PREFEITRA,
            //Itapipoca
            '230640501' => 76, // PREFEITRA,
            ////Crato
            '230420210' => 76, // Previdencia,
            '230420201' => 76, // Previdencia,
            //Guaraciaba do Norte.
            '230500101' => 76, // Prefeitura,
            //Aquiraz
            '230100008' => 76, // HOSPITAL REGIONAL
            //Uruoca
            '231390601' => 76, // PREFEITURA
            //Lavras da Mangabeira
            '230750201' => 76, // PREFEITURA
            //Or�s
            '230950801' => 76, // PREFEITURA
            '230950802' => 76, // CAMARA
            //Limoeiro do Norte
            '230760103' => 76, // SAAE
            //Abaiara
            '230010101' => 76, // PREFEITURA
            //Senador Pompeu
            '231270001' => 76, // PREFEITURA
            //Cari�s
            '230330301' => 76, // PREFEITURA
            //Varzea Alegre
            '231400301' => 76, // PREFEITURA
            //Beberibe
            '230220601' => 76, // PREFEITURA
            //ACOPIARA
            '230030901' => 2, // PREFEITURA
            //ICO
            '230540701' => 76, // PREFEITURA
            '230540707' => 76, // POLICLINICA
            //JUAZEIRO
            '230730401' => 77, // PREFEITURA
            '230730410' => 76, // PREVJUNO
            //MOMBACA
            '230850001' => 76, // PREFEITURA
            //IBARETAMA
            '230526601' => 76, // PREFEITURA
            //IBARETAMA
            '230700701' => 76, // PREFEITURA
            //ACOOPERVIDA
            'acoopervida' => 76, // ACOOPERVIDA
            //CATUNDA
            '230365901' => 76, // PREFEITURA
            //CRATEUS
            '230410301' => 76, // PREFEITURA
            //QUIXADA
            '231130601' => 5, // PREFEITURA
            //GUARAMIRANGA
            '230510001' => 76, // PREFEITURA
            //CEDRO
            '230380801' => 76, // PREFEITURA
            //ITAIÇABA
            '230620701' => 76, // PREFEITURA
            //SANTAQUITERIA
            '231220501' => 76, // PREFEITURA
            //GUAIUBA
            '230495401' => 76, // PREFEITURA
            //CAPISTRANO
            '230290901' => 76, // PREFEITURA
            //SOLONOPOLE
            '231300501' => 76, // PREFEITURA
            //IRAUÇUBA
            '230610801' => 77, // PREFEITURA
            //CHAVAL
            '230390701' => 76, // PREFEITURA
            //QUIXADA CM
            '231130602' => 76, // CAMARA
            //ALTANEIRA
            '230060601' => 77, // PREFEITURA
            //ITARGET
            'itarget' => 76, // ITARGET
            //ATM
            'atm' => 76, // ATM
            //C30
            'c30' => 77, // C30
            //CVSE
            'cvse' => 76, // CVSE
            //DEMONSTRACAO
            '230740309' => 76, // DEMONSTRACAO
            '000000001' => 76, // DEMONSTRACAO van thieu
            '000000002' => 76, // DEMONSTRACAO demonstracao2

        );

        if (!isset($idEntidades[CLIENTE])) {
            return 76;
        }
        return $idEntidades[CLIENTE];
    }

    public function get($params = array()) {

        $sql = "SELECT
                        e.*
                        ,cn.codigo codigo_cnae
                        ,fp.codigo codigo_fpas
                        ,format_cpf_cnpj_f(e.cnpj) cnpj_f
                        ,coalesce(fp.codigo::varchar,'') || ' - ' || coalesce(fp.descricao,'') fpas_descricao
                        ,coalesce(nj.codigo::varchar,'') || ' - ' || coalesce(nj.descricao,'') natureza_juridica_descricao
                        ,coalesce(cn.descricao,'') cnae_descricao
                        ,coalesce(m.nome,'') || ' - ' || coalesce(m.cod_uf,'') municipio_descricao
                        ,m.cod_ibge
                        ,m.cod_uf
                        ,m.nome cidade
                        ,c.descricao cargo_gestor_descricao
                        ,c.codigo cargo_gestor_codigo
                        ,nj.codigo natureza_juridica_codigo
                        ,nj.descricao natureza_juridica
                FROM
                        entidades e
                        JOIN fpas fp ON fp.id = e.fpas_id
                        JOIN naturezas_juridicas nj ON nj.id = e.natureza_juridica_id
                        JOIN cnae cn ON cn.id = e.cnae_id
                        LEFT JOIN cargos c ON c.id = e.cargo_gestor_id
                        LEFT JOIN municipios m ON m.id = e.municipio_id
                WHERE 1=1 "
            . (isset($params["id"]) ? " AND e.id = " . $params["id"] : "");

        $result = \DB::select($sql);
        if($result){
            return $result[0];
        }
        return $result;
    }
}
