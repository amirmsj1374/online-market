<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'province',
        'address',
        'phone',
        'discount_code'
    ];


    protected $casts = [
        'discount_code' => 'array'
    ];


    public function user()
    {
        $this->belongsTo(User::class);
    }
}
