<?php


namespace App\Http\Controllers;

use App\Http\Requests\CompaniesList;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Http\Resources\CompanyCollection;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    /**
     * @var CompanyRepositoryInterface $companyRepository
     */
    protected $companyRepository;

    /**
     * CompanyController constructor.
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Get companies list.
     *
     * @param CompaniesList $request
     * @return CompanyCollection
     */
    public function index(CompaniesList $request)
    {
        $limit = $request->get('limit');
        return new CompanyCollection($this->companyRepository->with(['score', 'prices'])->paginate($limit));
    }
}
