<?php

namespace App\Http\QueryPipelines\AppointmentPipeline\Filters;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Http\Request;

class SortByStartDate
{

    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $sortBy = $this->request->get('sort_by');
        $sortOrder = $this->request->get('sort_order', 'asc');

        if ($sortBy !== 'startTime') {
            return $next($builder);
        }

        if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            return $next($builder);
        }

        $builder->orderBy('startTime', $sortOrder);

        return $next($builder);
    }
}
