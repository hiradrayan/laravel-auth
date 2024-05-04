<?php

namespace Authentication\path\models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'is_locked',
        'ip',
        'description',
        'parameters',
    ];

    protected $casts = [
        'parameters' => 'array'
    ];

    public function user () {
        return $this->belongsTo(User::class,'user_id','user');
    }
}
