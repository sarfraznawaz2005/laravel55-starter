<?php

/*
 * Some traits might want to manipulate with attributes of an Eloquent Model,
 * this can however be done easy creating the getAttribute-method and/or
 * setAttribute-method. However if multiple traits uses those methods then they will
 * complain about eachother since it is only allow for a class to use one trait
 * with the same method. So if you are up to having a multiple traits using the
 * same methods to manipulate the Eloquent Model attributes then you might use
 * our methods instead for better support.
 *
 * https://github.com/larapack/attribute-manipulation
 *
 * */

namespace Modules\Core\Traits\Model;

use Closure;

trait Manipulateable
{
    /**
     * @var array List of setters to be ran
     */
    protected static $setter_manipulators = [];

    /**
     * @var array List of getters to be ran
     */
    protected static $getter_manipulators = [];

    /**
     * Adds a manipulator to the setter.
     *
     * @param $callback  \Closure
     */
    protected static function addSetterManipulator(Closure $callback)
    {
        static::$setter_manipulators[] = $callback;
    }

    /**
     * Adds a manipulator to the getter.
     *
     * @param $callback  \Closure
     */
    protected static function addGetterManipulator(Closure $callback)
    {
        static::$getter_manipulators[] = $callback;
    }

    /**
     * Gets an attribute value after running through the manipulators.
     *
     * @param $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        foreach (static::$getter_manipulators as $manipulator) {
            $value = $manipulator($this, $key, $value);
        }

        return $value;
    }

    /**
     * Gets an attribute value without running through the manipulators.
     *
     * @param $key
     *
     * @return mixed
     */
    public function getOriginalAttribute($key)
    {
        return parent::getAttribute($key);
    }

    /**
     * Sets an attribute value after running through the manipulators.
     *
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        foreach (static::$setter_manipulators as $manipulator) {
            $value = $manipulator($this, $key, $value);
        }

        parent::setAttribute($key, $value);
    }

    /**
     * Sets an attribute value without running through the manipulators.
     *
     * @param $key
     * @param $value
     */
    public function setOriginalAttribute($key, $value)
    {
        parent::setAttribute($key, $value);
    }
}