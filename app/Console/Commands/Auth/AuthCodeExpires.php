<?php

namespace App\Console\Commands\Auth;

use Illuminate\Console\Command;

use App\Modules\Auth\Interfaces\AuthCodeRepositoryInterface;

class AuthCodeExpires extends Command
{
    protected $signature = 'auth:code:expires';

    /**
     * @var string
     */
    protected $description = 'Update auth code statuses';

    /**
     * @param AuthCodeRepositoryInterface $repository
     * @return void
     */
    public function handle(
        AuthCodeRepositoryInterface $repository,
    ): void
    {
        $repository->updateStatusForExpired();
    }
}
