<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\Support\SortableInterface;
use App\Support\Criteria\CriteriaInterface;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

abstract class BaseRepository
{
    /**
     * @var Model|Builder
     */
    protected $model;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var Collection
     */
    protected $scopeQueries;

    /**
     * BaseRepository constructor.
     * @throws RepositoryException
     */
    public function __construct()
    {
        $this->resetEverything();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model() : string;

    /**
     * @return $this
     * @throws RepositoryException
     */
    public function resetEverything()
    {
        $this->resetModel();
        $this->resetCriteria();
        $this->resetScope();
        return $this;
    }

    /**
     * @return Model|Builder
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @throws RepositoryException
     * @return $this
     */
    public function resetModel()
    {
        $this->makeModel();
        return $this;
    }

    /**
     * Get Collection of Criteria
     *
     * @return Collection
     */
    public function getCriteria() : Collection
    {
        return $this->criteria;
    }

    /**
     * Reset all Criterias
     *
     * @return $this
     */
    public function resetCriteria()
    {
        $this->criteria = new Collection;
        return $this;
    }

    /**
    * Reset Query Scope
    *
    * @return $this
    */
    public function resetScope()
    {
        $this->scopeQueries = new Collection;
        return $this;
    }
    /**
     * Apply scope in current Query
     *
     * @throws RepositoryException
     * @return $this
     */
    protected function applyScope()
    {
        if ($this->scopeQueries->count() > 0) {
            foreach ($this->scopeQueries as $scopeQuery) {
                if (is_callable($scopeQuery)) {
                    $scopedModel = $scopeQuery($this->model);

                    if ($scopedModel === null) {
                        throw new RepositoryException('Scope query has returned NULL model. Check you code.');
                    }

                    $this->model = $scopedModel;
                }
            }
        }

        return $this;
    }

    /**
     * Query Scope
     *
     * @param Closure $scope
     *
     * @return $this
     */
    public function setScopeQuery(Closure $scope)
    {
        $this->scopeQueries->push($scope);
        return $this;
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel() : Model
    {
        $model = app()->make($this->model());
        if (! $model instanceof Model) {
            throw new RepositoryException("Class {$this->getModel()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }

    /**
     * @return $this
     */
    protected function applyCriteria()
    {
        $criteria = $this->getCriteria();
        if ($criteria) {
            foreach ($criteria as $c) {
                if ($c instanceof CriteriaInterface) {
                    $this->model = $c->apply($this->model, $this);
                }
            }
        }
        //dump($this->model);
        return $this;
    }

    /**
     * Push Criteria for filter the query
     *
     * @param $criteria
     *
     * @return $this
     * @throws RepositoryException
     */
    public function pushCriteria($criteria)
    {
        if (is_string($criteria)) {
            $criteria = new $criteria;
        }
        if (!$criteria instanceof CriteriaInterface) {
            throw new RepositoryException('Class ' . get_class($criteria) . ' must be an instance of App\\Support\\Contracts\\CriteriaInterface');
        }
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * Retrieve data array for populate field select
     *
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function lists($column, $key = null)
    {
        $this->applyCriteria();
        return $this->model->lists($column, $key);
    }

    /**
     * Retrieve data array for populate field select
     * Compatible with Laravel 5.3
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function pluck($column, $key = null)
    {
        $this->applyCriteria();
        return $this->model->pluck($column, $key);
    }

    /**
     * Sync relations
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @param bool $detaching
     * @return mixed
     */
    public function sync($id, $relation, $attributes, $detaching = true)
    {
        return $this->find($id)->{$relation}()->sync($attributes, $detaching);
    }

    /**
     * SyncWithoutDetaching
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @return mixed
     */
    public function syncWithoutDetaching($id, $relation, $attributes)
    {
        return $this->sync($id, $relation, $attributes, false);
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @throws RepositoryException
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->get($columns);

        $this->resetEverything();
        return $this->parserResult($results);
    }

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @throws RepositoryException
     *
     * @return mixed
     */
    public function first($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->first($columns);
        $this->resetEverything();
        return $this->parserResult($results);
    }

    /**
     * Retrieve first data of repository, or return new Entity
     *
     * @param array $attributes
     *
     * @throws RepositoryException
     *
     * @return mixed
     */
    public function firstOrNew(array $attributes = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->firstOrNew($attributes);
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Retrieve first data of repository, or create new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        try {
            $model = $this->model->firstOrCreate($attributes);
        } catch (Exception $exception) {
            $model = null;
        }
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     * @param string $method
     *
     * @throws RepositoryException
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $this->applyCriteria();
        $this->applyScope();

        $limit = ($limit === null ? config('repository.pagination.limit', 15) : $limit);
        $results = $this->model->{$method}($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetEverything();
        return $this->parserResult($results);
    }

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function simplePaginate($limit = null, $columns = ['*'])
    {
        return $this->paginate($limit, $columns, "simplePaginate");
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @throws RepositoryException
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->find($id, $columns);
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->where($field, '=', $value)->get($columns);
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     * @throws RepositoryException
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $this->applyConditions($where);
        $model = $this->model->get($columns);
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     * @throws RepositoryException
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->whereIn($field, $values)->get($columns);
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Find data by excluding multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     * @throws RepositoryException
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->whereNotIn($field, $values)->get($columns);
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Save a new entity in repository
     *
     * @throws RepositoryException
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = $this->model->newInstance($attributes);
        try {
            $model->save();
        } catch (Exception $e) {
            error()->notify('EnitityCreationError', 'Entity creation failed.', [
                'message'    => $e->getMessage(),
                'attributes' => $attributes,
                'modelClass' => $this->model()
            ]);
            $model = null;
        }
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     * @throws ModelNotFoundException
     * @throws MassAssignmentException
     * @throws RepositoryException
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->find($id);
        $model->fill($attributes);
        try {
            $model->save();
        } catch (Exception $e) {
            error()->notify('EnitityUpdateError', 'Entity update failed.', [
                'message'    => $e->getMessage(),
                'attributes' => $attributes,
                'modelClass' => $this->model()
            ]);
            $model = null;
        }
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @throws ModelNotFoundException
     * @throws MassAssignmentException
     * @throws RepositoryException
     * @return int
     */
    public function updateBulk(array $attributes)
    {
        $this->applyCriteria();
        $this->applyScope();

        $updated = 0;
        try {
            $updated = $this->model->update($attributes);
        } catch (Exception $e) {
            error()->notify('EnitityUpdateError', 'Entity bulk update failed.', [
                'message'    => $e->getMessage(),
                'attributes' => $attributes,
                'modelClass' => $this->model()
            ]);
            $model = null;
        }
        $this->resetEverything();

        return $updated;
    }

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     * @throws RepositoryException
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->updateOrCreate($attributes, $values);
        $this->resetEverything();
        return $this->parserResult($model);
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     * @throws RepositoryException
     * @return bool
     */
    public function delete($id)
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->find($id);
        $deleted = $model->delete();
        $this->resetEverything();
        return (bool) $deleted;
    }

    /**
     * @return bool
     */
    public function deleteAll()
    {
        $this->applyCriteria();
        $this->applyScope();

        $deleted = $this->model->delete();

        $this->resetEverything();
        return (bool) $deleted;
    }

    /**
     * Delete multiple entities by given criteria.
     *$
     * @param array $where
     * @throws RepositoryException|Exception
     * @return bool
     */
    public function deleteWhere(array $where) : bool
    {
        $this->applyCriteria();
        $this->applyScope();
        $this->applyConditions($where);
        $deleted = $this->model->delete();
        $this->resetEverything();

        return (bool)$deleted;
    }

    /**
     * Check if entity has relation
     *
     * @param string $relation
     *
     * @return $this
     */
    public function has($relation) : self
    {
        $this->model = $this->model->has($relation);
        return $this;
    }

    /**
     * Load relations
     *
     * @param array|string $relations
     *
     * @return $this
     */
    public function with($relations) : self
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Add subselect queries to count the relations.
     *
     * @param  mixed $relations
     * @return $this
     */
    public function withCount($relations) : self
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }

    /**
     * Load relation with closure
     *
     * @param string $relation
     * @param Closure $closure
     *
     * @return $this
     */

    public function whereHas($relation, $closure) : self
    {
        $this->model = $this->model->whereHas($relation, $closure);
        return $this;
    }

    /**
     * Set hidden fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function hidden(array $fields) : self
    {
        $this->model->setHidden($fields);
        return $this;
    }

    public function orderBy($column, $direction = 'desc') : self
    {
        $this->model = $this->model->orderBy($column, $direction);
        //dd($this->first());
        return $this;
    }

    /**
     * Set visible fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function visible(array $fields) : self
    {
        $this->model->setVisible($fields);
        return $this;
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     * @return void
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    /**
     * Apply sorted to model
     * @throws RepositoryException
     * @return $this
     */
    public function sorted() : self
    {
        $model = $this->model instanceof Builder ? $this->model->getModel() : $this->model;
        if (! ($model instanceof SortableInterface)) {
            throw new RepositoryException($this->model() . ' should implement ' . SortableInterface::class);
        }

        $this->setScopeQuery(function ($query) {
            /** @var Builder $query */
            return $query->sorted();
        });

        return $this;
    }

    /**
     * Wrapper result data
     *
     * @param mixed $result
     * @return mixed
     */
    public function parserResult($result)
    {
        //TODO: Place checks here
        return $result;
    }

    /**
     * @param string $field
     * @return mixed
     */
    public function sum(string $field) : int
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->sum($field);
        $this->resetEverything();
        return $this->parserResult($model);
    }
}
