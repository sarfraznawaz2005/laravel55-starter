<?php

namespace Modules\Core\Traits\Model;

trait Purgeable
{
    /**
     * @var array List of attribute names which should not be saved to the database.
     *
     * protected $purge = [];
     */

    /**
     * @var array List of original attribute values before they were purged.
     */
    protected $originalPurgeableValues = [];

    /**
     * Boot the purgeable trait for a model.
     *
     * @return void
     */
    public static function bootPurgeable()
    {
        /*
         * Remove any purge attributes from the data set
         */
        static::creating(function ($model) {
            $model->purgeAttributes();
        });

        static::updating(function ($model) {
            $model->purgeAttributes();
        });

        static::created(function ($model) {
            $model->restorePurgedValues();
        });

        static::updated(function ($model) {
            $model->restorePurgedValues();
        });
    }

    /**
     * Removes purged attributes from the dataset, used before saving.
     *
     * @param null $attributesToPurge
     * @return array Current attribute set
     * @internal param mixed $attributes Attribute(s) to purge, if unspecified, $purgable property is used
     *
     */
    public function purgeAttributes($attributesToPurge = null)
    {
        if ($attributesToPurge !== null) {
            $purgeable = is_array($attributesToPurge) ? $attributesToPurge : [$attributesToPurge];
        } else {
            $purgeable = $this->getPurgeableAttributes();
        }

        $attributes = $this->getAttributes();

        $cleanAttributes = array_diff_key($attributes, array_flip($purgeable));

        $originalAttributes = array_diff_key($attributes, $cleanAttributes);

        if (is_array($this->originalPurgeableValues)) {
            $this->originalPurgeableValues = array_merge($this->originalPurgeableValues, $originalAttributes);
        } else {
            $this->originalPurgeableValues = $originalAttributes;
        }

        return $this->attributes = $cleanAttributes;
    }

    /**
     * Returns a collection of fields that will be hashed.
     */
    public function getPurgeableAttributes()
    {
        if (property_exists(get_called_class(), 'purge')) {
            return $this->purge;
        }

        return [];
    }

    /**
     * Returns the original values of any purged attributes.
     */
    public function getOriginalPurgeValues()
    {
        return $this->originalPurgeableValues;
    }

    /**
     * Returns the original values of any purged attributes.
     */
    public function getOriginalPurgeValue($attribute)
    {
        return isset($this->originalPurgeableValues[$attribute])
            ? $this->originalPurgeableValues[$attribute]
            : null;
    }

    /**
     * Restores the original values of any purged attributes.
     */
    public function restorePurgedValues()
    {
        $this->attributes = array_merge($this->getAttributes(), $this->originalPurgeableValues);

        return $this;
    }
}