<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetorController extends Controller
{
    public function index()
    {
        try {
            $query = DB::table('setor')->select('*')->orderBy("id", "asc")->paginate(10);

            return response()->json(['data' => $query]);

        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function find($id) {
      try {
        $query = DB::table('setor')->select('*')->where('id', $id)->get();

        return response()->json(['data' => $query]);

      }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 300);
        }
    }
    public function store(Request $request)
    {
        try {
            $response = Setor::create([
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
            $orgao = Setor::find($request['id']);

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
            $orgao = Setor::find($id);
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
