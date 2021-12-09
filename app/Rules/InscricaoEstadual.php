<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InscricaoEstadual implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A Inscrição estadual digitada é inválida';
    }
}
