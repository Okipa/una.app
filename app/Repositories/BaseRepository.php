<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * The repository model
     *
     * @var Model
     */
    protected $model;

    /**
     * The query builder
     *
     * @var Builder
     */
    protected $query;

    /**
     * Alias for the query limit
     *
     * @var int
     */
    protected $take;

    /**
     * Alias for the query limit
     *
     * @var int
     */
    protected $skip;

    /**
     * Array of related models to eager load
     *
     * @var array
     */
    protected $with = [];

    /**
     * Array of one or more where clause parameters
     *
     * @var array
     */
    protected $wheres = [];

    /**
     * Array of one or more where in clause parameters
     *
     * @var array
     */
    protected $whereIns = [];

    /**
     * Array of one or more ORDER BY column/value pairs
     *
     * @var array
     */
    protected $orderBys = [];

    /**
     * Array of scope methods to call on the model
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * Get the model from the IoC container
     */
    public function __construct()
    {
        $this->model = app()->make($this->model);
    }

    /**
     * Get the repository model to access to its methods
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get all the model records in the database
     *
     * @return Collection
     */
    public function all()
    {
        $this->newQuery()->eagerLoad();
        $models = $this->query->get();
        $this->unsetClauses();

        return $models;
    }

    /**
     * Count the number of specified model records in the database
     *
     * @return int
     */
    public function count()
    {
        return $this->get()->count();
    }

    /**
     * Create a new model record in the database
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        $this->unsetClauses();

        return $this->model->create($data);
    }

    /**
     * Create one or more new model records in the database
     *
     * @param array $data
     * @return Collection
     */
    public function createMultiple(array $data)
    {
        $models = new Collection();
        foreach ($data as $d) {
            $models->push($this->create($d));
        }

        return $models;
    }

    /**
     * Delete one or more model records from the database
     *
     * @return mixed
     */
    public function delete()
    {
        $this->newQuery()->setClauses()->setScopes();
        $result = $this->query->delete();
        $this->unsetClauses();

        return $result;
    }

    /**
     * Delete the specified model record from the database
     *
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $this->unsetClauses();

        return $this->find($id)->delete();
    }

    /**
     * Delete multiple records
     *
     * @param array $ids
     * @return int
     */
    public function deleteMultipleById(array $ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * Get the first specified model record from the database
     *
     * @return Model
     */
    public function first()
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();
        $model = $this->query->firstOrFail();
        $this->unsetClauses();

        return $model;
    }

    /**
     * Get all the specified model records in the database
     *
     * @return Collection
     */
    public function get()
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();
        $models = $this->query->get();
        $this->unsetClauses();

        return $models;
    }

    /**
     * Get the specified model record from the database
     *
     * @param $id
     * @return Model
     */
    public function find($id)
    {
        $this->unsetClauses();
        $this->newQuery()->eagerLoad();

        return $this->query->findOrFail($id);
    }

    /**
     * Get the specified model record from the database from its attribute
     *
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function findBy($attribute, $value)
    {
        return $this->model->where($attribute, '=', $value)->firstOrFail();
    }

    /**
     * Set the query limit
     *
     * @param int $limit
     * @return $this
     */
    public function take($limit)
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Set the query skip
     *
     * @param $start
     * @return $this
     */
    public function skip($start)
    {
        $this->skip = $start;

        return $this;
    }

    /**
     * Set an ORDER BY clause
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * Update the specified model record in the database
     *
     * @param $id
     * @param array $data
     * @return Model
     */
    public function updateById($id, array $data)
    {
        $this->unsetClauses();
        $model = $this->find($id);
        $model->update($data);

        return $model;
    }

    /**
     * @param $column
     * @param $operator
     * @param null $value
     * @return $this
     */
    public function where($column, $operator, $value = null)
    {
        if (!isset($value)) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = compact('column', 'operator', 'value');

        return $this;
    }

    /**
     * Add a simple where in clause to the query
     *
     * @param string $column
     * @param mixed $values
     * @return $this
     */
    public function whereIn($column, $values)
    {
        $values = is_array($values) ? $values : [$values];
        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Set Eloquent relationships to eager load
     *
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        if (is_string($relations)) $relations = func_get_args();
        $this->with = $relations;

        return $this;
    }

    /**
     * Create a new instance of the model's query builder
     *
     * @return $this
     */
    protected function newQuery()
    {
        $this->query = $this->model->newQuery();

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load
     *
     * @return $this
     */
    protected function eagerLoad()
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * Set clauses on the query builder
     *
     * @return $this
     */
    protected function setClauses()
    {
        foreach ($this->wheres as $where) {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }
        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }
        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }
        if (isset($this->take) and !is_null($this->take)) {
            $this->query->take($this->take);
        }
        if (isset($this->skip) and !is_null($this->skip)) {
            $this->query->skip($this->skip);
        }
        if (isset($this->paginate) and !is_null($this->paginate)) {
            $this->query->paginate($this->paginate);
        }

        return $this;
    }

    /**
     * Set query scopes
     *
     * @return $this
     */
    protected function setScopes()
    {
        foreach ($this->scopes as $method => $args) {
            $this->query->$method(implode(', ', $args));
        }

        return $this;
    }

    /**
     * Reset the query clause parameter arrays
     *
     * @return $this
     */
    protected function unsetClauses()
    {
        $this->wheres = [];
        $this->whereIns = [];
        $this->orderBys = [];
        $this->take = null;
        $this->skip = null;
        $this->paginate = null;
        $this->scopes = [];

        return $this;
    }

    /**
     * Get paginated list
     *
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();
        $models = $this->query->paginate($perPage, $columns);
        $this->unsetClauses();

        return $models;
    }

    /**
     * @param void
     * @return void
     */
    public function sanitizePositions()
    {
        // we get the max position of the table and the count of entities
        $slides_data = $this->model->selectRaw('MAX(position) as max')
            ->selectRaw('COUNT(*) as count')
            ->first();

        // if we detect a position gap between the max and the count
        if ($slides_data->max > $slides_data->count) {
            // we correct the position of all entities
            $slides = $this->model->orderBy('position', 'asc')->get();

            $verification_position = 0;
            foreach ($slides as $s) {
                // we update the incorrect positions
                if ($s->position !== $verification_position + 1) {
                    $s->position = $verification_position + 1;
                    $s->save();
                }
                // we increment the verification position
                $verification_position++;
            }
        }
    }

    /**
     * @param int $parent_entity_id
     * @return int
     */
    public function updatePositions(int $parent_entity_id = null)
    {
        // we get the entities concerned by the position incrementation regarding the given previous entity
        if ($parent_entity_id && $parent_entity = $this->model->find($parent_entity_id)) {
            // if a parent is defined
            // we get the entities hierarchically inferiors to the parent
            $other_entities = $this->model->where('position', '>', $parent_entity->position)
                ->orderBy('position', 'desc')
                ->get();
        } else {
            // if the entity has to be the master one
            // we get all entities
            $other_entities = $this->model->orderBy('position', 'desc')->get();
        }

        // we increment the position of the selected entities
        foreach ($other_entities as $entities) {
            $entities->position += 1;
            $entities->save();
        }

        // we get the new position to apply it to the current entity
        $new_position = isset($parent_entity) ? ($parent_entity->position + 1) : 1;

        return $new_position;
    }
}