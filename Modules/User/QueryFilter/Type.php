<?php

namespace Modules\User\QueryFilter;

class Type extends Filter
{

    protected function applyFilter($builder)
    {
        if (!empty(\request($this->filterName()))) {

            return $builder->where('type', 'like', '%' . \request($this->filterName()) . '%');
        } else {

            return $builder;
        }
    }
}
