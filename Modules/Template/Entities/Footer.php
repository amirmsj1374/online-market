<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'link'
    ];

    protected $casts = [
        'link' => 'array',
    ];

    // protected $appends = ['links'];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\FooterFactory::new();
    }


    // public function getlinksAttribute()
    // {
    //     return json_decode($this->link);
    // }
}
