<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposDocumentos extends Model
{
    use HasFactory;
    protected $table = 'tipo_documentos';
    protected $fillable =  [
        'descricao',
        "updated_at",
        "created_at"
    ];
}
