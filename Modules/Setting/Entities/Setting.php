<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'website',
        'email',
        'phone',
        'mobile',
        'socialNetwork',
    ];

    protected $casts = [
        'socialNetwork' => 'array',
    ];

    protected static function newFactory()
    {
        return \Modules\Setting\Database\factories\SettingFactory::new();
    }

        /**
     * registerMediaCollections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('setting');
    }
}
