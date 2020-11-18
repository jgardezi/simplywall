<?php


namespace App\Repositories;

use Illuminate\Support\Collection;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * Get all companies.
     *
     * @return Collection
     */
    public function all();

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($limit = 15, $columns = ['*']);
}
