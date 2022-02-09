<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Content extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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

    public $appends = ['image'];

    public function getImageAttribute()
    {

        if ($this->getMedia()) {

            return  $this->getFirstMedia('content')->getFullUrl();
        }
    }

    protected static function newFactory()
    {
        return \Modules\Template\Database\factories\ContentFactory::new();
    }

    /**
     * registerMediaCollections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('content');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
