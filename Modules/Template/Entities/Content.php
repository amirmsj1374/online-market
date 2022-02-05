<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'buttonLabel',
        'customClass',
        'cols',
        'link',
        'order',
        'section_id',
        'time',
        'type',
    ];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\ContentFactory::new();
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
