<?php

namespace App\Providers;

use App\Repositories\AccountRepository;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\InforRecipientRepositoryInterface;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Repositories\InforRecipientRepository;
use App\Repositories\SurveyRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
        $this->app->bind(SurveyRepositoryInterface::class, SurveyRepository::class);
        $this->app->bind(InforRecipientRepositoryInterface::class, InforRecipientRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

    }
}
