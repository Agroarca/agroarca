<?php

namespace App\Rules;

use App\Services\Administracao\DominioService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsDominio implements Rule
{
    protected $table;
    protected $column;

    public function __construct($table, $column = null)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        $columnName = $this->column ?? 'id';

        return DB::table($this->table)
            ->where('dominio_id', DominioService::getDominioId())
            ->where($columnName, $value)
            ->exists();
    }

    public function message()
    {
        return 'O campo :attribute não existe na base de dados.';
    }
}
