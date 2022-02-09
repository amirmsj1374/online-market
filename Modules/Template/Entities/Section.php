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



    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\SectionFactory::new();
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
