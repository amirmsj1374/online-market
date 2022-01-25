<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Element extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'name',
        'order',
        'page_id',
        'status',
        'type',
    ];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\ElementFactory::new();
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
