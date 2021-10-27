<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Inventory;
use Modules\User\Entities\User;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'quantity',
        'subject_id',
        'subject_type'
    ];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\CartFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
