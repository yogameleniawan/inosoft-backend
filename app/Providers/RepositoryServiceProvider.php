<?php

namespace App\Providers;

use App\Interfaces\KendaraanInterface;
use App\Interfaces\MobilInterface;
use App\Interfaces\MotorInterface;
use App\Interfaces\ReportInterface;
use App\Interfaces\TransactionInterface;
use App\Interfaces\UserInterface;
use App\Repositories\KendaraanRepository;
use App\Repositories\MobilRepository;
use App\Repositories\MotorRepository;
use App\Repositories\ReportRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(MobilInterface::class, MobilRepository::class);
        $this->app->bind(MotorInterface::class, MotorRepository::class);
        $this->app->bind(KendaraanInterface::class, KendaraanRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(ReportInterface::class, ReportRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
