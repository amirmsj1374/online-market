<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'selected',
    ];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\TemplateFactory::new();
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
