<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Relationship\CompanyRelationship;

class Company extends Model
{
    use CompanyRelationship;

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
}
