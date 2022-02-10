<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'name',
        'template_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\PageFactory::new();
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function layouts()
    {
        return $this->hasMany(Layout::class);
    }
}
