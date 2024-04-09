<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.municipios';
    protected $fillable = [
        "id",
        "cod_ibge",
        "nome",
        "created_at",
        "updated_at",
        "cod_uf",
    ];

    public function entidades(){
        return $this->hasMany(Entidades::class, 'municipio_id');
    }
}
