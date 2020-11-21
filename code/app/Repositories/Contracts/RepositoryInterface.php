<?php


namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($limit = 15, $columns = ['*']);

    /**
     * Load relations
     *
     * @param array|string $relations
     * @return mixed
     */
    public function with($relations);
}
