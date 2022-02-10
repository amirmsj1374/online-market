<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'element_id',
        'status',
        'title',
    ];


    public $appends = ['icon_address'];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\SectionFactory::new();
    }


    public function getIconAddressAttribute()
    {
        return  $this->element->icon_address;
    }
    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function layout()
    {
        return $this->hasOne(Layout::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
