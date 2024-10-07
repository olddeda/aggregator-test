<?php

namespace App\Modules\News\Http\Queries;

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
                $q->where('news.id', 'like', '%'.$value.'%')
                    ->orWhere('news.title', 'like', '%'.$value.'%')
                    ->orWhere('news.link', 'like', '%'.$value.'%')
                    ->orWhere('news.description', 'like', '%'.$value.'%')
                    ->orWhere('news.source', 'like', '%'.$value.'%')
                ;
            });
    }
}
