<?php

namespace App\Providers;

use App\Models\User;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\Generator\SecurityRequirement;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Dedoc\Scramble\Support\RouteInfo;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-product', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('export-product', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-category', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('viewApiDocs', function () {
            return true;
        });

        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/v1/');
            })
            ->afterOpenApiGenerated(function (OpenApi $openApi) {
                $openApi->components->addSecurityScheme(
                    'Bearer Auth',
                    SecurityScheme::http('bearer')->as('Bearer Auth')
                );
            })
            ->withOperationTransformers(function (Operation $operation, RouteInfo $routeInfo) {
                $middleware = $routeInfo->route->gatherMiddleware();

                if (collect($middleware)->contains(fn (string $item) => str_contains($item, 'auth:sanctum'))) {
                    $operation->addSecurity(new SecurityRequirement(['Bearer Auth' => []]));
                }
            });
    }
}
