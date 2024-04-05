<?php

namespace App\Http\Controllers;

use App\Models\Salas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Exception;

class SalasController extends Controller
{
    public function index()
    {
        try {
            $query = DB::table('salas')->select('*')->orderBy("id", "asc")->paginate(10);

            return response()->json(['data' => $query]);

        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function find($id) {
      try {
        $query = DB::table('salas')->select('*')->where('id', $id)->get();

        return response()->json(['data' => $query]);

      }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 300);
        }
    }
    public function store(Request $request)
    {
        try {
            $response = Salas::create([
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
            $salas = Salas::find($request['id']);

            if (!$salas) {
                throw new Exception('Não foi possível encontrada esse orgão!');
            }
            $salas->update([
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
            $salas = Salas::find($id);
            if(!$salas) {
                throw new Exception("Não foi possível encontrada esse orgão!");
            }
            $salas->delete([
                'id' => $id,
            ]);
            return response()->json(['success' => "Regristo Excluído com Sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(["msg" => $e->getMessage()], 300);
        }
    }
}
