<?php

namespace Modules\Category\Http\Helper;

use AliBayat\LaravelCategorizable\Category as LaravelCategorizableCategory;
use Illuminate\Support\Facades\Log;

class Category extends LaravelCategorizableCategory
{
    public $appends = ['height'];

    protected $casts = [
        'child' => 'array'
    ];

    public function getHeightAttribute()
    {

        $height = 1;
        if ($this->parent()->get()->isNotEmpty() && $this->getPrevSiblings()->isNotEmpty()) {
            foreach ($this->getPrevSiblings() as $key => $prevSibling) {
                $height += $this->descendantsAndSelf($prevSibling->id)->count();
            }
        }
        return $height;
    }
}