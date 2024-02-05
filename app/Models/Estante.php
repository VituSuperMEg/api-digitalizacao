<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estante extends Model
{
    use HasFactory;

    protected $table = "estantes";
    protected $fillable = [
        "id",
        "descricao",
        "updated_at",
        "created_at"
    ];
}
