<?php


namespace App\Models\Traits\Attribute;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

trait PriceAttribute
{
    /**
     * Get the company price's standard deviation by number of day(s).
     *
     * @param int $days price fluctuations or volatility in price within the last 90 days
     * @param string $sort Direction of the sort order.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function priceByNumberOfDays($days = 90, $sort = 'asc')
    {
        $date = Carbon::today()->subDays($days);
        $collection = self::where('data_created', '>=', $date)->get()->groupBy('company_id');

        $companiesStd = $collection->map(function ($item, $key) {
            return self::standardDeviation($item);
        });

        if ($sort === 'desc')
            $companiesStd = $companiesStd->sortDesc();
        else
            $companiesStd = $companiesStd->sort();

        return $companiesStd;
    }

    /**
     * Calculate the standard deviation of the price.
     *
     * @param Collection $companyPrices
     * @return float
     */
    private static function standardDeviation(Collection $companyPrices)
    {
        $std = 0.00;
        $numberOfItems = $companyPrices->count();
        if ($numberOfItems === 0)
            return $std;

        $avg = $companyPrices->avg('price');
        $companyPrices->map(function ($item) use (&$std, $avg) {
            $std += pow(($item->price - $avg), 2);
        });

        return sqrt($std/$numberOfItems);
    }
}
