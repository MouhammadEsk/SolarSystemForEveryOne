<?php

namespace App\Http\QueryPipelines\TeamPipeline\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;

class SortByStartDate
{

    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $sortBy = $this->request->get('sort_by');
        if ($sortBy !== 'startTime') {
            return $next($builder);
        }

        $builder->where('id',Auth::id())->with(['appointment'=>function($q){
            $q->orderBy('startTime','asc');
        }]);
        return $next($builder);
    }
}
