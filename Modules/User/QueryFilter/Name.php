<?php

namespace Modules\User\QueryFilter;

class Name extends Filter
{

    protected function applyFilter($builder)
    {
        if (!empty(\request($this->filterName()))) {

            return $builder->where('name', 'like', '%' . \request($this->filterName()) . '%');
        } else {

            return $builder;
        }
    }
}
