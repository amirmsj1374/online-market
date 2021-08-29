<?php

namespace Modules\User\QueryFilter;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($request, Closure $next)
    {

        if (!\request()->has($this->filterName())) {

            return $next($request);
        }

        $builder = $next($request);

        return $this->applyFilter($builder);
    }

    protected abstract function applyFilter($builder);

    protected  function filterName()
    {

        return Str::camel(class_basename($this));
    }
}
