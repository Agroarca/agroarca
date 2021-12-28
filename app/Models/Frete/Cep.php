<?php

namespace App\Models\Frete;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cep extends Model
{
    use HasFactory;
    protected $table = 'ceps';
    protected $fillable = [
        'cep',
        'google_place_id',
        'google_place_id_updated',
        'latitude',
        'longitude',
    ];

    public function setGooglePlaceIdAttribute($value){
        $this->attributes['google_place_id'] = $value;
        $this->attributes['google_place_id_updated'] = Carbon::now()->toDate();
    }
}
