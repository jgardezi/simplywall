<?php


namespace App\Repositories\Eloquent;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\CriteriaInterface;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * Collection of Criteria
     *
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * BaseRepository constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->criteria = new Collection();
        $this->makeModel();
        $this->boot();
    }

    /**
     * For initializing Criteria in child repository.
     */
    public function boot() {}

    /**
     * @throws Exception
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    /**
     * @return Model|object
     * @throws BindingResolutionException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function all($columns = ['*'])
    {
        $this->applyCriteria();

        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        return $results;
    }

    /**
     * @inheritDoc
     */
    public function paginate($limit = 15, $columns = ['*'])
    {
        $this->applyCriteria();
        $results = $this->model->paginate($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $results;
    }

    /**
     * Push Criteria for filter the query
     *
     * @param $criteria
     * @return $this
     * @throws Exception
     */
    public function pushCriteria($criteria)
    {
        if (is_string($criteria)) {
            $criteria = new $criteria;
        }
        if (!$criteria instanceof CriteriaInterface) {
            throw new Exception("Class " . get_class($criteria) . " must be an instance of Prettus\\Repository\\Contracts\\CriteriaInterface");
        }
        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * Get Collection of Criteria
     *
     * @return Collection
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Apply criteria in current Query
     *
     * @return $this
     */
    protected function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        $criteria = $this->getCriteria();

        if ($criteria) {
            foreach ($criteria as $c) {
                if ($c instanceof CriteriaInterface) {
                    $this->model = $c->apply($this->model, $this);
                }
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }
}
