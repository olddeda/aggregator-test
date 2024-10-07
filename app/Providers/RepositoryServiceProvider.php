<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Modules\Auth\Interfaces\AuthCodeRepositoryInterface;
use App\Modules\Auth\Repositories\AuthCodeRepository;
use App\Modules\News\Interfaces\NewsRepositoryInterface;
use App\Modules\News\Interfaces\NewsCategoryRepositoryInterface;
use App\Modules\News\Interfaces\NewsSourceRepositoryInterface;
use App\Modules\News\Repositories\NewsRepository;
use App\Modules\News\Repositories\NewsCategoryRepository;
use App\Modules\News\Repositories\NewsSourceRepository;
use App\Modules\Users\Interfaces\UserRepositoryInterface;
use App\Modules\Users\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(AuthCodeRepositoryInterface::class, AuthCodeRepository::class);
        $this->app->bind(NewsRepositoryInterface::class, NewsRepository::class);
        $this->app->bind(NewsCategoryRepositoryInterface::class, NewsCategoryRepository::class);
        $this->app->bind(NewsSourceRepositoryInterface::class, NewsSourceRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
