<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";
    
    protected $fillable = [
        'name',
        'state_id',
        'state_code',
        'country_id',
        'country_code',
        'latitude',
        'longitude',
        'flag'
    ];
    
    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id','id');
    }
    public function state()
    {
        return $this->belongsTo('App\Models\State','state_id','id');
    }
}
