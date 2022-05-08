<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_id',
        'email',
        'phone',
        'mobile',
        'zipcode',
        'city',
        'province',
        'address',
    ];

    protected static function newFactory()
    {
        return \Modules\Setting\Database\factories\MarketAddressFactory::new();
    }

    public function setting()
    {
        return $this->belongsTo(setting::class);
    }
}
