<?php

namespace App\Models\Cadastros;

use App\Enums\Cadastros\Usuarios\TipoPessoaEnum;
use App\Helpers\Formatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    protected $fillable = [
        'nome',
        'email',
        'password',
        'modo_escuro',
        'tipo_pessoa',
        'cpf',
        'cnpj',
        'celular',
        'status',
        'tipo'
    ];

    public function getCpfFormatadoAttribute(){
        return Formatter::cpf($this->cpf);
    }

    public function getCnpjFormatadoAttribute(){
        return Formatter::cnpj($this->cnpj);
    }

    public function getCelularFormatadoAttribute(){
        return Formatter::telefone($this->celular);
    }

    public function getDocumentoAttribute(){
        return $this->tipo_pessoa == TipoPessoaEnum::PessoaJuridica ? $this->cnpjFormatado :  $this->cpfFormatado;
    }

    public function getNomeTipoPessoaAttribute(){
        return ($this->tipo_pessoa == TipoPessoaEnum::PessoaJuridica) ? "Pessoa Jurídica" : "Pessoa Física";
    }

    public function enderecos(){
        return $this->hasMany(UsuarioEndereco::class);
    }
}
