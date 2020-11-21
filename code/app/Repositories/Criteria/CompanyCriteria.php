<?php


namespace App\Repositories\Criteria;


use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Contracts\CriteriaInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyCriteria implements CriteriaInterface
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $orderBy = $this->request->get('orderBy', null);
        $exchangeSymbols = $this->request->get('exchangeSymbols', null);
        $scoreTotal = $this->request->get('scoreTotal', null);
        $sortBy = $this->request->get('sortBy', 'asc');
        $sortBy = !empty($sortBy) ? $sortBy : 'asc';
        $table = $model->getModel()->getTable();

        if (isset($exchangeSymbols) && !empty($exchangeSymbols)) {
            $symbols = explode(',', $exchangeSymbols);
            if (count($symbols) > 1) {
                $model = $model->whereIn('exchange_symbol', $symbols);
            } else {
                $model = $model->where('exchange_symbol', $symbols[0]);
            }
        }

        // single join for either for scoreTotal or orderBy Total score.
        if ((isset($scoreTotal) && !empty($scoreTotal))
            || (isset($orderBy) && !empty($orderBy) && $orderBy === 'score')) {
            $model = $model
                ->leftJoin('CompanyScore', $table.'.id', '=', 'CompanyScore.company_id')
                ->addSelect($table.'.*');
        }

        if (isset($scoreTotal) && !empty($scoreTotal)) {
            $model = $model
                ->where('CompanyScore.total', $scoreTotal);
        }

        if (isset($orderBy) && !empty($orderBy)) {
            if($orderBy === 'score') {
                $model = $model
                    ->orderBy('CompanyScore.total', $sortBy);
            } elseif ($orderBy === 'volatility') {
                // TODO
                // $date = Carbon::today()->subDays(90);
                //    ->leftJoin('CompanyPriceClose', $table.'.id', '=', 'CompanyPriceClose.company_id')
                //    ->where('CompanyPriceClose.total', '>=', $date);
            } else {
                $model = $model->orderBy($orderBy, $sortBy);
            }
        }

        return $model;
    }

    protected function parserFieldsOrderBy($model, $orderBy, $sortedBy)
    {
        $split = explode('|', $orderBy);
        if(count($split) > 1) {
            /**
             * score|total -> join score on current_table.product_id = products.id order by description
             */
            $table = $model->getModel()->getTable();
            $sortTable = $split[0];
            $sortColumn = $split[1];

            $split = explode(':', $sortTable);
            if(count($split) > 1) {
                $sortTable = $split[0];
                $keyName = $table.'.'.$split[1];
            } else {
                $prefix = Str::singular($sortTable);
                $keyName = $table.'.'.$prefix.'_id';
            }

            $model = $model
                ->leftJoin($sortTable, $keyName, '=', $sortTable.'.id')
                ->orderBy($sortColumn, $sortedBy)
                ->addSelect($table.'.*');
        } else {
            $model = $model->orderBy($orderBy, $sortedBy);
        }

        return $model;
    }
}
