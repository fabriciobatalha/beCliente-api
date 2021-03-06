<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'nome', 'email', 'password', 'cep', 'rua', 'numero', 'bairro', 'cidade', 'estado'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function cadastrar($request) {
        if (empty($request->nome) || empty($request->email) || empty($request->senha) || empty($request->cep) || empty($request->rua) || empty($request->numero) || empty($request->bairro) || empty($request->cidade) || empty($request->estado)) {
            return response()->json(['message' => 'Preencha todos os campos!'], 500);
        }

        return User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->senha),
            'cep' => $request->cep,
            'rua' => $request->rua,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado
        ]);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
