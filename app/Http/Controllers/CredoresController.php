<?php

namespace App\Http\Controllers;

use App\Helpers\AppUtil;
use App\Models\Credores;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Exception;

class CredoresController extends Controller
{

    public function index()
    {
        try {
            $query = DB::table('credores')->select("*")->get();

            $result = array();

            foreach ($query as $q) {
                $q->cpf = AppUtil::formataCnpjCpf($q->cpf);
                $q->telefone = AppUtil::formataTelefone($q->telefone);

                array_push($result, $q);
            }
            return response()->json(["data" => $query]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            if (!isset($request) && empty($request)) {
                throw new Exception("Ocorreu um erro");
            }
            Credores::create([
                "nome" => $request["nome"],
                "tipo_documento" => $request["tipo_documento"],
                "cpf" => $request["cpf"],
                "logradouro" => $request["logradouro"],
                "numero" => $request["numero"],
                "bairro" => $request["bairro"],
                "cep" => $request["cep"],
                "e-mail" => $request["e-mail"],
                "cidade" => $request["cidade"],
                "telefone" => $request["telefone"],
                "telefone_complementar" => $request["telefone_complementar"],
                "banco" => $request["banco"],
                "agencia" => $request["agencia"],
                "conta" => $request["conta"],
                "observacoes" => $request["observacoes"],
            ]);
            return response()->json(["success" => "Registro Criado com sucesso!"]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
