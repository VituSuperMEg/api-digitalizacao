<?php

namespace App\Http\Controllers;

use App\Models\Estante;
use Exception;
use Faker\Calculator\Ean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstanteController extends Controller
{
    protected $model;

    public function __construct(Estante $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        try {
            $query = DB::table("estantes")->select('*')->paginate(10);

            return response()->json(["data" => $query]);
        } catch (Exception $e) {
            return response()->json(["erorr" => $e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            if (!isset($request['descricao'])  && empty($request['descricao'])) {
                throw new Exception("Informe a descrição");
            }
            $this->model->create([
                "descricao" => strtoupper($request['descricao']),
            ]);
            return response()->json(["success" => "Registro criado com sucesso!"]);
        } catch (Exception $e) {
            return response()->json(["erorr" => $e->getMessage()]);
        }
    }
    public function find($id) {
        try {
          $query = DB::table('estantes')->select('*')->where('id', $id)->get();

          return response()->json(['data' => $query]);

        }catch(Exception $e) {
              return response()->json(['error' => $e->getMessage()], 300);
          }
      }
      public function update(Request $request)
      {
          try {
              $estante = Estante::find($request['id']);

              if (!$estante) {
                  throw new Exception('Não foi possível encontrada esse orgão!');
              }
              $estante->update([
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
            $estante = Estante::find($id);
            if(!$estante) {
                throw new Exception("Não foi possível encontrada esse orgão!");
            }
            $estante->delete([
                'id' => $id,
            ]);
            return response()->json(['success' => "Regristo Excluído com Sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(["msg" => $e->getMessage()], 300);
        }
    }
}
