<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
