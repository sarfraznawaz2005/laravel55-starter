<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2017
 * Time: 12:30 PM
 */

namespace Modules\Core\Models;

use Carbon\Carbon;
use LaravelArdent\Ardent\Ardent;

class CoreModel extends Ardent
{
    // hydrates on new entries' validation
    public $autoHydrateEntityFromInput = true;
    // hydrates whenever validation is called (for updates)
    public $forceEntityHydrationFromInput = false;
    public $autoPurgeRedundantAttributes = true;

    // Auto hash passwords
    public static $passwordAttributes = ['password'];
    public $autoHashPasswordAttributes = true;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }

    # added to get Cacheable trait working because Ardent was changing this function
    # which was affecting Cacheable trait
    public function newQueryWithoutScopes()
    {
        $builder = $this->newEloquentBuilder(
            $this->newBaseQueryBuilder()
        );

        // Once we have the query builders, we will set the model instances so the
        // builder can easily access any information it may need from the model
        // while it is constructing and executing various queries against it.
        return $builder->setModel($this)->with($this->with);
    }

    /**
     * created_at column accessor.
     *
     * @param $value
     * @return mixed
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    /**
     * updated_at column accessor.
     *
     * @param $value
     * @return mixed
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }
}