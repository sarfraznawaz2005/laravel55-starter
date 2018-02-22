<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2018
 * Time: 12:30 PM
 */

namespace Modules\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use KingOfCode\Upload\Uploadable;
use Sarfraznawaz2005\Eventable\Eventable;
use Watson\Validating\ValidatingTrait;

/**
 * @property string $created_at
 * @property string $updated_at
 * @property int $id
 */
class CoreModel extends Model
{
    use ValidatingTrait;
    use Uploadable;
    use Eventable;

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
        return Carbon::parse($value)->format(config('core.settings.global_date_format'));
    }

    /**
     * updated_at column accessor.
     *
     * @param $value
     * @return mixed
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('core.settings.global_date_format'));
    }
}
