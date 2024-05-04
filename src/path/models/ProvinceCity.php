<?php

namespace Authentication\path\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceCity extends Model
{
    use HasFactory;

    public function cities ()
    {
        return $this->hasMany(ProvinceCity::class,'parent_id','id');
    }

    public function province ()
    {
        return $this->belongsTo(ProvinceCity::class,'parent_id','id');
    }

    public function provinceUsers ()
    {
        return $this->hasMany(ProvinceCity::class,'province_id','id');
    }

    public function cityUsers ()
    {
        return $this->hasMany(ProvinceCity::class,'city_id','id');
    }
}


