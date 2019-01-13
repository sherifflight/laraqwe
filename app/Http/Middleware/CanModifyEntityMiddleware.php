<?php

namespace App\Http\Middleware;

use App\Exceptions\Permission\CannotModifyEntityException;
use App\Services\Permission\ModifyAccessManager;
use Closure;

class CanModifyEntityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $entity
     * @param string $idParamName
     * @return mixed
     * @throws CannotModifyEntityException
     */
    public function handle($request, Closure $next, string $entity, string $idParamName = 'id')
    {
        $modifyAccessManager = app(ModifyAccessManager::class);
        $modifyAccessManager->setUser($request->user('dashboard'));

        if (! $modifyAccessManager->canModify($entity, $request->route($idParamName))) {
            throw new CannotModifyEntityException;
        }

        return $next($request);
    }
}
