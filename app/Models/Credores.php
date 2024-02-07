<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credores extends Model
{
    use HasFactory;
    protected $table = "credores";
    protected $fillable = [
        "id",
        "nome",
        "tipo_documento",
        "cpf",
        "logradouro",
        "numero",
        "bairro",
        "cep",
        "e-mail",
        "cidade",
        "telefone",
        "telefone_complementar",
        "banco",
        "agencia",
        "conta",
        "observacoes",
        "updated_at",
        "created_at"
    ];
}
