<?php

namespace App\Http\Controllers;

use App\Helpers\AppUtil;
use App\Models\Orgaos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrgaosController extends Controller
{
    public function index()
    {
        try {
            $query = DB::table('orgaos')->select('*')->orderBy("id", "asc")->paginate(10);

            $result = array();

            foreach($query as $q) {
                $q->cpf = AppUtil::formataCnpjCpf($q->cpf);
                array_push($result, $q);
            }
            return response()->json(['data' => $query]);

        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function find($id) {
      try {
        $query = DB::table('orgaos')->select('*')->where('id', $id)->get();

        return response()->json(['data' => $query]);

      }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 300);
        }
    }
    public function store(Request $request)
    {
        try {
            $response = Orgaos::create([
                'descricao' => strtoupper($request['descricao']),
                'responsavel' => $request['responsavel'],
                'cpf' => $request['cpf'],
                'num_expediente' => $request['num_expediente'],
            ]);
            return response()->json(['success' => "Regristo Criado com Sucesso!"], 200);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 300);
        }
    }
    public function update(Request $request)
    {
        try {
            $orgao = Orgaos::find($request['id']);

            if (!$orgao) {
                throw new Exception('Não foi possível encontrada esse orgão!');
            }
            $orgao->update([
                'descricao' => $request['descricao']
            ]);
            return response()->json(['success' => 'Registro Alterado com Sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(["msg" => $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        try {
            $orgao = Orgaos::find($id);
            if(!$orgao) {
                throw new Exception("Não foi possível encontrada esse orgão!");
            }
            $orgao->delete([
                'id' => $id,
            ]);
            return response()->json(['success' => "Regristo Excluído com Sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(["msg" => $e->getMessage()], 300);
        }
    }
}
