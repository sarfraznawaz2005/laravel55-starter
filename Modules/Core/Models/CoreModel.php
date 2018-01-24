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

/**
 * @property string $created_at
 * @property string $updated_at
 * @property int $id
 */
class CoreModel extends Model
{
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
