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
            $query = DB::table("estantes")->select('*')->get();

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
    public function update($id, Request $request)
    {

        try {

            $find = $this->model->find($id);

            if (!$find) {
                throw new Exception("Não foi possível localizar este registro");
            }

            $find->update([
                "descricao" => strtoupper($request["descricao"]),
            ]);

            return response()->json(["success" => "Registro alterado com sucesso"]);
        } catch (Exception $e) {
            return response()->json(["erorr" => $e->getMessage()]);
        }
    }
    public function delete ($id) {

    }
}
