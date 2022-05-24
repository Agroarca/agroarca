<?php

namespace App\Models\Frete;

use App\Traits\GooglePlaceId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cep extends Model
{
    use HasFactory, GooglePlaceId;
    protected $table = 'ceps';
    protected $fillable = [
        'cep'
    ];
}
