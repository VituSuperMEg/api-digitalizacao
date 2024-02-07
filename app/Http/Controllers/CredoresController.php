<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CredoresController extends Controller
{

    public function index() {
        try {
          $query = DB::table('credores')->select("*")->get();

        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
