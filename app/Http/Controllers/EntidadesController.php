<?php

namespace App\Http\Controllers;

use App\Models\Entidades;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntidadesController extends Controller
{
    public function getEstados(){

        $list = config('clientes.estados');
        $lista_estados = [];
        if($list){
            foreach($list as $key => $value){
                $identificador = explode('.', $key);
                $lista_estados[] = ['value' => $identificador[1], 'label' => $value];
            }
        }
        sort($lista_estados);

        return response()->json(['data' => $lista_estados]);
    }
    public function postMunicipios(Request $request){
        $request = request()->input();
        $estado_id = $request['estado_id'];
        $list = config('clientes.municipios');
        $lista_municipios = [];
        if($list){
            foreach($list as $key => $value){
                $identificador = explode('.', $key);
                if($estado_id === $identificador[1]){
                    $lista_municipios[] = ['value' => $identificador[2], 'label' => $value];
                }
            }
        }
        sort($lista_municipios);
        return response()->json(['data' => $lista_municipios]);
    }
    public function postEntidades(){
        $request = request()->input();
        $entidade_id = $request['municipio_id'];
        $list = config('clientes.entidades');
        $lista_entidades = [];
        if($list){
            foreach($list as $key => $value){
                $identificador = explode('.', $key);
                if($entidade_id === $identificador[2]){
                    $lista_entidades[] = ['value' => $identificador[2].$identificador[3], 'label' => $value];;
                }
            }
        }
        sort($lista_entidades);
        return response()->json(['data' => $lista_entidades]);
    }
    public function getEntidade(Request $request){
        $cliente = $request['entidade'];
        try {
            // if(!isset($cliente) || empty($cliente) || $cliente == 'null') {
            //     throw new Exception("Selecione uma entidade");
            // }
            $cod_estado = substr($cliente, 0, strlen($cliente) - 7);
            $cod_municipio = substr($cliente, 0, strlen($cliente) - 2);
            $cod_entidade =  substr($cliente, strlen($cliente) - 2, strlen($cliente));

            $estados = config('clientes.estados');
            $municipios = config('clientes.municipios');
            $entidades = config('clientes.entidades');

            $estado = $estados['estados.'.$cod_estado];
            $municipio = $municipios['municipios.'.$cod_estado.'.'.$cod_municipio];
            $entidade = $entidades['entidades.'.$cod_estado.'.'.$cod_municipio.'.'.$cod_entidade];

            $entidade_id = config("database.connections.{$request['entidade']}.entidade_id");
            DB::setDefaultConnection($request['entidade']);
            $resultEntidade = Entidades::find($entidade_id);
        } catch(Exception $e) {
            return response()->json(['message' => 'Cliente ainda não disponível/configurado!. '.$e->getMessage()]);
        }

        $razao_social = '';
        if($resultEntidade) {
            $razao_social = $resultEntidade->razao_social;
        } else {
            $razao_social = '';
        }

        $data = [
            'estado' => $estado ? $estado : '',
            'municipio' => $municipio ? $municipio : '',
            'entidade' => $razao_social,
            'entidade_id' => $entidade_id,
        ];

        return response()->json(['data' => $data], 200);
    }
    public function getCheckCliente(){
        $request = request()->input();
        $result = config('database.connections.'.$request['cliente']);
        if($result) {
            return response()->json(['data' => ['check' => true, 'message' => 'Sucesso']], 200);
        } else {
            return response()->json(['data' => ['check' => false, 'message' => 'Código inexistente!']], 200);
        }
    }

}
