<?php

namespace App\Providers;

use App\Repositories\CommentsRepository;
use App\Repositories\Interfaces\CommentsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CommentsRepositoryInterface::class, CommentsRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
