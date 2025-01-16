<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\RoleRepository;
use App\Repositories\GroupRepositoryInterface;
use App\Repositories\GroupRepository;
use App\Repositories\MemberRepositoryInterface;
use App\Repositories\MemberRepository;
use App\Repositories\ActivityRepositoryInterface;
use App\Repositories\ActivityRepository;
use App\Services\UserServiceInterface;
use App\Services\UserService;
use App\Services\RoleServiceInterface;
use App\Services\RoleService;
use App\Services\GroupServiceInterface;
use App\Services\GroupService;
use App\Services\MemberServiceInterface;
use App\Services\MemberService;
use App\Services\ActivityServiceInterface;
use App\Services\ActivityService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);

        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(GroupServiceInterface::class, GroupService::class);
        $this->app->bind(MemberServiceInterface::class, MemberService::class);
        $this->app->bind(ActivityServiceInterface::class, ActivityService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

