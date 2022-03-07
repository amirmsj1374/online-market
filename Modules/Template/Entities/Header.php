<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Header extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification',
        'link',
        'siteTitle',
        'PhoneNumber',
    ];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\HeaderFactory::new();
    }
}
