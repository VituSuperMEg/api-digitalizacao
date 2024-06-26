<?php

namespace App\Http\Controllers;

use App\Models\TiposDocumentos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiposDocumentosController extends Controller
{

    protected $model;

    public function __construct(TiposDocumentos $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        try {
            $query = DB::table("tipo_documentos as td")
                ->select("*")
                ->paginate(10);

            return response()->json(["data" => $query]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            $this->model->create([
                "descricao" => strtoupper($request["descricao"]),
            ]);
            return response()->json(["success" => "Registro criado com sucesso"]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }
    public function listOptions($descricao)
    {
        try {
            if (isset($descricao) && !empty($descricao)) {
                $query = DB::table('tipo_documentos')
                    ->select('*')
                    ->where("descricao", 'ilike', "{$descricao}%")
                    ->get();
            }
            return response()->json(["data" => $query]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
