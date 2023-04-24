<?php

namespace App\Http\QueryPipelines\TeamPipeline;

use App\Http\QueryPipelines\TeamPipeline\Filters\SortByStartDate;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;

class TeamPipeline extends Pipeline
{
    protected ?Request $request;

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    protected function pipes(): array
    {
        return [
            new SortByStartDate(request: $this->request),
        ];
    }

    public static function make(Builder $builder, Request $request): Builder
    {
        return app(static::class)
            ->setRequest(request: $request)
            ->send($builder)
            ->thenReturn();
    }
}
