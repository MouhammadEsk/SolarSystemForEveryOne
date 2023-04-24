<?php

namespace App\Http\QueryPipelines\AppointmentPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByType
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('type', null);

        if (!$filterTerm) {
            return $next($builder);
        }

        $builder->where('type', $filterTerm);

        return $next($builder);
    }
}
