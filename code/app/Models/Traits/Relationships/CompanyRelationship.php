<?php


namespace App\Models\Traits\Relationships;


use App\Models\Price;
use App\Models\Score;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait CompanyRelationship
 * @package App\Models\Traits\Relationships
 */
trait CompanyRelationship
{
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
     * Get the snowflake score record of the company.
     *
     * @return HasOne
     */
    public function score()
    {
        return $this->hasOne(Score::class);
    }
}
