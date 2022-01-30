<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layout extends Model
{
    use HasFactory;

    protected $fillable = [
        'element_id',
        'header_title',
        'order',
        'page_id',
        'status',
    ];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\LayoutFactory::new();
    }

    public function page()
    {
        return $this->hasOne(Page::class);
    }
    public function elements()
    {
        return $this->hasMany(Element::class);
    }
}
