<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'title',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Product\Database\factories\DownloadFactory::new();
    // }
}
