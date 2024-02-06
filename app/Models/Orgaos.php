<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgaos extends Model
{
    use HasFactory;

    protected $table = 'orgaos';
    protected $fillable =  [
        'descricao',
        'responsavel',
        'cpf',
        'num_expediente',
    ];
}
