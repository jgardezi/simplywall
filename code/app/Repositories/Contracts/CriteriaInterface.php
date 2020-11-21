<?php


namespace App\Repositories\Contracts;


/**
 * Interface CriteriaInterface
 *
 * For larger applications you’ll most definitely need to make some
 * custom queries to fetch more specific data set defined by some criteria.
 *
 * @package App\Repositories\Contracts
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
