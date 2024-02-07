<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
    use HasFactory;

    protected $table = "salas";
    protected $fillable = [
        "descricao"
    ];
}
