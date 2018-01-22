<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/29/2017
 * Time: 8:10 PM
 */

namespace Modules\Core\Traits\Model;


use Illuminate\Database\Eloquent\Model;

trait Playable
{
    /**
     * Whether we're currently maintaing player.
     *
     * @param bool
     */
    protected $logPlayer = true;

    public static function bootPlayable()
    {
        static::registerListeners();
    }

    /**
     * Register events we need to listen for.
     *
     * @return void
     */
    public static function registerListeners()
    {
        static::creating(function (Model $model) {
            if (!$model->isLoggingPlayer()) {
                return;
            }

            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });

        static::updating(function (Model $model) {
            if (!$model->isLoggingPlayer()) {
                return;
            }

            $model->updated_by = auth()->id();
        });

        if (static::usingSoftDeletes()) {
            static::deleting(function (Model $model) {
                if (!$model->isLoggingPlayer()) {
                    return;
                }

                $model->deleted_by = auth()->id();
                $model->save();
            });

            static::restoring(function (Model $model) {
                if (!$model->isLoggingPlayer()) {
                    return;
                }

                $model->deleted_by = null;
            });
        }
    }

    /**
     * Has the model loaded the SoftDeletes trait.
     *
     * @return bool
     */
    public static function usingSoftDeletes()
    {
        static $usingSoftDeletes;

        if (is_null($usingSoftDeletes)) {
            return $usingSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes',
                class_uses(get_called_class()));
        }

        return $usingSoftDeletes;
    }

    /**
     * Get the user that created the model.
     */
    public function creator()
    {
        return $this->belongsTo($this->getUserClass(), 'created_by');
    }

    /**
     * Get the user that edited the model.
     */
    public function editor()
    {
        return $this->belongsTo($this->getUserClass(), 'updated_by');
    }

    /**
     * Get the user that deleted the model.
     */
    public function remover()
    {
        return $this->belongsTo($this->getUserClass(), 'deleted_by');
    }

    /**
     * Check if we're maintaing player on the model.
     *
     * @return bool
     */
    public function isLoggingPlayer()
    {
        return $this->logPlayer;
    }

    /**
     * Stop maintaining player on the model.
     *
     * @return void
     */
    public function disableLoggingPlayer()
    {
        $this->logPlayer = false;
    }

    /**
     * Start maintaining player on the model.
     *
     * @return void
     */
    public function enableLoggingPlayer()
    {
        $this->logPlayer = true;
    }

    /**
     * Get the class being used to provide a User.
     *
     * @return string
     */
    protected function getUserClass()
    {
        if (get_class(auth()) === 'Illuminate\Auth\Guard') {
            return auth()->getProvider()->getModel();
        }

        return auth()->guard()->getProvider()->getModel();
    }
}