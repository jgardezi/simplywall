<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\Attribute\PriceAttribute;

class Price extends Model
{
    use PriceAttribute;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'CompanyPriceClose';

    /**
     * Get the company that has the price.
     *
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
