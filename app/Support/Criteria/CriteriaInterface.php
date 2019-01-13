<?php

namespace App\Support\Criteria;

use App\Support\Repositories\RepositoryInterface;

/**
 * Interface CriteriaInterface
 * @package App\Support\Criteria
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
