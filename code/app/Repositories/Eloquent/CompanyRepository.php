<?php


namespace App\Repositories\Eloquent;


use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Criteria\CompanyCriteria;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function boot()
    {
        $this->pushCriteria(app(CompanyCriteria::class));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Company::class;
    }
}
