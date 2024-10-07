<?php

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Http\Queries\ListFilter;
use App\Modules\Auth\Http\Resources\AuthCodeListResource;
use App\Modules\Auth\Http\Resources\AuthCodeResource;
use App\Modules\Auth\Models\AuthCode;

class AuthCodeController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return AuthCodeListResource::collection((QueryBuilder::for(AuthCode::class)
            ->allowedFilters([
                AllowedFilter::custom('query', new ListFilter),
                'status',
            ])
            ->allowedSorts([
                'id',
                'login',
                'code',
                'status',
                'created_at',
            ])
            ->defaultSort('-created_at')
            ->paginate($request->get('perPage', 20))));
    }

    /**
     * @param AuthCode $authCode
     * @return JsonResponse
     */
    public function show(AuthCode $authCode): JsonResponse
    {
        return response()->json(AuthCodeResource::make($authCode));
    }
}
