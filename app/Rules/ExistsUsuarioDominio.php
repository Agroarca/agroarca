<?php

namespace App\Rules;

use App\Models\Cadastros\Usuario;
use Illuminate\Contracts\Validation\Rule;

class ExistsUsuarioDominio implements Rule
{

    public function passes($attribute, $value)
    {
        return Usuario::find($value) != null;
    }

    public function message()
    {
        return 'O campo :attribute não existe na base de dados.';
    }
}
