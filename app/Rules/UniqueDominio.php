<?php

namespace App\Rules;

use App\Services\Administracao\DominioService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueDominio implements Rule
{
    protected $table;
    protected $column;
    protected $except;
    protected $exceptColumn;

    public function __construct($table, $column = null, $except = null, $exceptColumn = 'id')
    {
        $this->table = $table;
        $this->column = $column;
        $this->except = $except;
        $this->exceptColumn = $exceptColumn;
    }

    public function passes($attribute, $value)
    {
        $columnName = $this->column ?? $attribute;

        $query = DB::table($this->table)
            ->where('dominio_id', DominioService::getDominioId())
            ->whereNotNull($columnName)
            ->where($columnName, $value);


        if (!is_null($this->except) && $this->except > 0) {
            $query->where($this->exceptColumn, '!=', $this->except);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'O campo :attribute já está sendo utilizado.';
    }
}
