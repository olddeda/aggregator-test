<?php

namespace App\Modules\Auth\Http\Queries;

use Illuminate\Database\Eloquent\Builder;

use Spatie\QueryBuilder\Filters\Filter;

class ListFilter implements Filter
{
    /**
     * @param Builder $query
     * @param $value
     * @param string $property
     * @return void
     */
    public function __invoke(Builder $query, $value, string $property): void
    {
        $query
            ->where(function ($q) use ($value) {
                $q->where('auth_codes.id', 'like', '%'.$value.'%')
                    ->orWhere('auth_codes.login', 'like', '%'.$value.'%')
                    ->orWhere('auth_codes.code', 'like', '%'.$value.'%')
                ;
            });
    }
}
