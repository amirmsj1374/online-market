<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'element_id',
        'buttonLabel',
        'buttonLink',
        'customClass',
        'cols',
        'description',
        'link',
        'order',
        'subtitle',
        'time',
        'title',
    ];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\ContentFactory::new();
    }

    public function element()
    {
        return $this->belongsTo(Element::class);
    }
}
