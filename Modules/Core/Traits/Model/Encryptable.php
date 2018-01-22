<?php

namespace Modules\Core\Traits\Model;

use Crypt;
use Exception;

trait Encryptable
{
    /**
     * @var array List of attribute names which should be encrypted
     *
     * protected $encrypt = [];
     */

    /**
     * Boot the Encryptable trait for a model.
     *
     * @throws Exception
     */
    public static function bootEncryptable()
    {
        if (!isset(class_uses(get_called_class())[Manipulateable::class])) {
            throw new Exception(sprintf('You must use the ' . Manipulateable::class . ' trait in %s to use the Encryptable trait.',
                get_called_class()));
        }

        static::addSetterManipulator(function ($model, $key, $value) {
            if (array_key_exists($key, array_flip($model->getEncryptAttributes()))) {
                return Crypt::encrypt($value);
            }

            return $value;
        });

        static::addGetterManipulator(function ($model, $key, $value) {
            if (array_key_exists($key, array_flip($model->getEncryptAttributes()))) {
                return Crypt::decrypt($value);
            }

            return $value;
        });
    }

    /**
     * Returns a collection of fields that will be encrypted.
     *
     * @return array
     */
    public function getEncryptAttributes()
    {
        if (property_exists(get_called_class(), 'encrypt')) {
            return $this->encrypt;
        }

        return [];
    }
}