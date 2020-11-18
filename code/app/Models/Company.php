<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    /**
     * Customized name for created_at.
     */
    const CREATED_AT = 'date_generated';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Company';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are cast as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['date_generated'];

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the prices for the company.
     *
     * @return HasMany
     */
    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    /**
     * Get the last know share price.
     *
     * @param string $column
     * @return HasMany
     */
    public function lastKnowPrice($column = 'date_created')
    {
        return $this->prices()->latest($column);
    }

    /**
     * Get the snowflake score record of the company.
     *
     * @return HasOne
     */
    public function score()
    {
        return $this->hasOne(Score::class);
    }
}
