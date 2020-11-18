<?php


namespace App\Http\Controllers;

use App\Repositories\CompanyRepositoryInterface;
use App\Http\Resources\CompanyCollection;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepositoryInterface $companyRepository
     */
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        return new CompanyCollection($this->companyRepository->paginate());
    }
}
