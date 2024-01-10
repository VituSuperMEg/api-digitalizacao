<?php

namespace App\Http\Controllers;

use App\Models\Orgaos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrgaosController extends Controller
{
    public function index()
    {
        $query = DB::table('orgaos')->select('*')->get();

        return response()->json(['data' => $query]);
    }
    public function store(Request $request)
    {
        $response = Orgaos::create([
            'descricao' => $request['descricao']
        ]);
        return response()->json(['data' => $response]);
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
            return response()->json(['msg' => 'Registration updated']);
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
        } catch (Exception $e) {
            return response()->json(["msg" => $e->getMessage()]);
        }
    }
}
