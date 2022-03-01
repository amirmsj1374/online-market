<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Tags\HasTags;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Log;

class Article extends Model
{
    use HasFactory, HasTags, Sluggable;

    protected $fillable = [
        'name',
        'status',
        'description',
        'body',
    ];

    protected static function newFactory()
    {
        return \Modules\Article\Database\factories\ArticleFactory::new();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}
