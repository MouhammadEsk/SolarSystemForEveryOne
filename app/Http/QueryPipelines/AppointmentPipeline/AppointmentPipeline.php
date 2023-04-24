<?php

namespace App\Http\QueryPipelines\AppointmentPipeline;

use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\AppointmentPipeline\Filters\FilterByStatus;
use App\Http\QueryPipelines\AppointmentPipeline\Filters\FilterByType;
use App\Http\QueryPipelines\AppointmentPipeline\Filters\SortByStartDate;

class AppointmentPipeline extends Pipeline
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
            new FilterByStatus(request: $this->request),
            new FilterByType(request: $this->request),
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
