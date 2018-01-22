<?php
/**
 * Todo: Convert this into Laravl Package.
 *
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/29/2017
 * Time: 8:10 PM
 */

### NOTE: ###
# To use this trait, first create logs table by creating migration and table with:

/*
Schema::create('logs', function ($table) {
    $table->increments('id');
    $table->string('model');
    $table->integer('model_id');
    $table->integer('user_id')->nullable();
    $table->string('user_name')->nullable();
    $table->string('action');
    $table->string('description');
    $table->string('url');
    $table->timestamps();

    $table->index(array('model_id', 'model'));
});
*/

namespace Modules\Core\Traits\Model;


use DB;
use Illuminate\Database\Eloquent\Model;

trait ModelLogger
{
    /**
     * Whether we're currently maintaing model log.
     *
     * @param bool
     */
    protected $modelLoggerEnabled = true;

    /**
     * Name of model used in description. Should be specified in model
     *
     * @param string
     */
    //protected static $modelLoggerName = null;


    public static function bootModelLogger()
    {
        static::registerModelLogListeners();
    }

    /**
     * Register events we need to listen for.
     *
     * @return void
     */
    public static function registerModelLogListeners()
    {
        $userid = static::user() ? static::user()->id : '0';
        $username = static::user() ? static::user()->fullname : '';
        $modelName = isset(static::$modelLoggerName) ? static::$modelLoggerName : null;

        if (!$modelName) {
            $modelName = explode('\\', get_called_class());
            $modelName = end($modelName);
        }

        if (!$username) {
            if (static::user()) {
                $username = static::user()->first_name . ' ' . static::user()->last_name;
            }
        }

        if (!$username) {
            if (static::user()) {
                $username = static::user()->name;
            }
        }

        if (!$username) {
            $username = 'Unknown';
        }

        static::created(function (Model $model) use ($userid, $username, $modelName) {
            if (!$model->isEnabled()) {
                return;
            }

            $action = 'created';
            $description = $modelName . ' was ' . $action . ' by ' . $username;

            DB::table('logs')->insert([
                'model' => get_called_class(),
                'model_id' => $model->id,
                'user_id' => $userid,
                'user_name' => $username,
                'action' => $action,
                'description' => $description,
                'url' => request()->fullUrl(),
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
        });

        static::updated(function (Model $model) use ($userid, $username, $modelName) {
            if (!$model->isEnabled()) {
                return;
            }

            $action = 'updated';
            $description = $modelName . ' was ' . $action . ' by ' . $username;

            DB::table('logs')->insert([
                'model' => get_called_class(),
                'model_id' => $model->id,
                'user_id' => $userid,
                'user_name' => $username,
                'action' => $action,
                'description' => $description,
                'url' => request()->fullUrl(),
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
        });

        static::deleted(function (Model $model) use ($userid, $username, $modelName) {
            if (!$model->isEnabled()) {
                return;
            }

            $action = 'deleted';
            $description = $modelName . ' was ' . $action . ' by ' . $username;

            DB::table('logs')->insert([
                'model' => get_called_class(),
                'model_id' => $model->id ?: 0,
                'user_id' => $userid,
                'user_name' => $username,
                'action' => $action,
                'description' => $description,
                'url' => request()->fullUrl(),
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
        });
    }

    /**
     * Check if we're maintaing player on the model.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->modelLoggerEnabled;
    }

    /**
     * Gets logged user instance
     *
     * @return bool|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected static function user()
    {
        if (auth()->check()) {
            return auth()->user();
        }

        return false;
    }
}