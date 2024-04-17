<?php

namespace App\Http\Controllers;

use App\Models\Municipios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipiosController extends Controller
{
    public function obterMunicipioPorCodIbge (Request $request, $cod) {
        $cod = str_split($cod, 7);

        $mun = DB::table("municipios")->select('nome')->where('cod_ibge', $cod)->first();
        
        return response()->json(["data" =>  $mun]);
    }
}
