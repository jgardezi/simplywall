<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    /**
     * Customized name for created_at.
     */
    const CREATED_AT = 'date_created';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'CompanyScore';

    /**
     * Get the company that has the snowflake score.
     *
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
