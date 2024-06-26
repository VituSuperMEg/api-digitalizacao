<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.acl_usuarios';
    protected $fillable = [
        "id",
        "login",
        "senha",
        "ativo",
        "celular",
        "email",
        "numero_cpf",
        "nome",
        "usuario_app",
        "recuperacao_senha",
        "cod_sms_recuperacao_senha",
        "usuario_somente_app",
        "atendente",
        "status",
        "ponto_eletronico_app",

        "criado_por",
        "atualizado_por",
        "criado_em",
        "alterado_em",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
      return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * Automatically hash the password when setting it.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['senha'] = Hash::make($value);
    }
    public function getDecryptedPassword()
    {
        return decrypt($this->password);
    }
}
