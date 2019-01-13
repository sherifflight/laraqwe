<?php

namespace App\Repositories\Criteria;

use App\Models\User;
use App\Support\Criteria\CriteriaInterface;
use App\Support\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class UserCriteria implements CriteriaInterface
{
    /** @var string */
    protected $relationToUser;

    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user, $relationToUser = 'users')
    {
        $this->user = $user;
        $this->relationToUser = $relationToUser;
    }

    /**
     * @param Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $user = $this->user;

        return $model->whereHas(
            $this->relationToUser,
            function ($query) use ($user) {
                /** @var $query Builder */
                return $query->where('id', $user->id);
            }
        );
    }
}
