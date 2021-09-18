<?php

namespace Modules\User\QueryFilter;

class Mobile extends Filter
{

    protected function applyFilter($builder)
    {
        if (!empty(\request($this->filterName()))) {

            return $builder->where('mobile', 'like', '%' . \request($this->filterName()) . '%');
        } else {

            return $builder;
        }
    }
}
