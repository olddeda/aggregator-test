<?php

namespace App\Modules\News\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Controllers\Controller;
use App\Modules\News\Http\Resources\NewsListResource;
use App\Modules\News\Http\Resources\NewsResource;
use App\Modules\News\Http\Queries\ListFilter;
use App\Modules\News\Models\News;

class NewsController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return NewsListResource::collection((QueryBuilder::for(News::class)
            ->with(['categories'])
            ->allowedFilters([
                AllowedFilter::custom('query', new ListFilter),
            ])
            ->allowedSorts([
                'id',
                'title',
                'link',
                'source',
                'published_at',
            ])
            ->defaultSort('-published_at')
            ->paginate($request->get('perPage', 20))));
    }

    /**
     * @param News $news
     * @return JsonResponse
     */
    public function show(News $news): JsonResponse
    {
        return response()->json(NewsResource::make($news));
    }
}
