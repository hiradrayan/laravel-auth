<?php

namespace Authentication\path\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hash',
        'is_active',
        'agent',
        'login_at',
        'login_ip',
        'logout_at',
        'logout_ip',
    ];

    protected $dates = [
        'login_at',
        'logout_at',
    ];

    public $timestamps = false;

    public function user () {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
