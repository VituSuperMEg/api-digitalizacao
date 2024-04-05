<?php

namespace App\Http\Controllers;

use App\Models\Caixas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaixasController extends Controller
{
    public function index()
    {
        try {
            $query = DB::table('caixas')->select('*')->orderBy("id", "asc")->paginate(10);

            return response()->json(['data' => $query]);

        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function find($id) {
      try {
        $query = DB::table('caixas')->select('*')->where('id', $id)->get();

        return response()->json(['data' => $query]);

      }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 300);
        }
    }
    public function store(Request $request)
    {
        try {
            $response = Caixas::create([
                'descricao' => strtoupper($request['descricao']),
            ]);
            return response()->json(['success' => "Regristo Criado com Sucesso!"], 200);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 300);
        }
    }
    public function update(Request $request)
    {
        try {
            $caixas = Caixas::find($request['id']);

            if (!$caixas) {
                throw new Exception('Não foi possível encontrada esse orgão!');
            }
            $caixas->update([
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
            $caixas = Caixas::find($id);
            if(!$caixas) {
                throw new Exception("Não foi possível encontrada esse orgão!");
            }
            $caixas->delete([
                'id' => $id,
            ]);
            return response()->json(['success' => "Regristo Excluído com Sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(["msg" => $e->getMessage()], 300);
        }
    }
}
