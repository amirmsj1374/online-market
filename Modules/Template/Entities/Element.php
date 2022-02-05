<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Element extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'label',
        'name',
        'template_id',
        'status',
        'type',
        'description',
        'icon_address',
        'inputs'
    ];

    protected $casts  = ['inputs' => 'array'];

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\ElementFactory::new();
    }

    /**
     * registerMediaCollections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('element');
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function layout()
    {
        return $this->belongsToMany(Layout::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
