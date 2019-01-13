<?php

namespace App\Http\Middleware;

use App\Exceptions\Permission\CannotAccessModuleException;
use App\Services\Permission\ModuleAccessManager;
use App\Support\ResponseTrait;
use Closure;

class HasAccessToModuleMiddleware
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $module
     * @return mixed
     * @throws CannotAccessModuleException
     */
    public function handle($request, Closure $next, string $module)
    {
        $moduleAccessManager = app(ModuleAccessManager::class);

        if (
            ! $moduleAccessManager
                ->setUser($request->user('dashboard'))
                ->hasAccessTo($module)
        ) {
            throw new CannotAccessModuleException;
        }

        return $next($request);
    }
}
