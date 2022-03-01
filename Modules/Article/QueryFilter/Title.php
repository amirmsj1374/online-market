<?php

namespace Modules\Article\QueryFilter;

use Illuminate\Support\Facades\Log;

class Title extends Filter
{

    protected function applyFilter($builder)
    {
        if (!empty(\request($this->filterName()))) {

            return $builder->where('title', 'like', '%' . \request($this->filterName()) . '%');
        } else {

            return $builder;
        }
    }
}
