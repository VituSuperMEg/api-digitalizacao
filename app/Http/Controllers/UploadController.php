<?php

namespace App\Http\Controllers;

use App\Helpers\AppUtil;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request) {
        $file = $request->file('file');
        $url = AppUtil::uploadS3($file);
        return response()->json(["success" => $url]);
    }
}
