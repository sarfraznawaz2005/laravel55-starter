<?php

namespace Modules\Core\Traits\Model;

use Exception;
use Illuminate\Support\Str;

trait Sluggable
{
    /**
     * @var array List of attributes to automatically generate unique URL names (slugs) for.
     *
     * protected $slugs = [];
     */

    /**
     * Boot the sluggable trait for a model.
     *
     * @return void
     */
    public static function bootSluggable()
    {
        /*
         * Set slugged attributes on new records
         */
        static::creating(function ($model) {
            $model->slugAttributes();
        });

        static::updating(function ($model) {
            $model->slugAttributes();
        });
    }

    /**
     * Returns the slug collection.
     *
     * @return void
     */
    public function getSlugAttribute()
    {
        if (property_exists(get_called_class(), 'slug')) {
            return $this->slug;
        }

        return [];
    }

    /**
     * Adds slug attributes to the dataset, used before saving.
     *
     * @return void
     */
    public function slugAttributes()
    {
        foreach ($this->getSlugAttribute() as $slugAttribute => $sourceAttributes) {
            $this->setSluggedValue($slugAttribute, $sourceAttributes);
        }
    }

    /**
     * Sets a single slug attribute value.
     *
     * @param string $slugAttribute Attribute to populate with the slug.
     * @param mixed $sourceAttributes Attribute(s) to generate the slug from.
     *                                 Supports dotted notation for relations.
     * @param int $maxLength Maximum length for the slug not including the counter.
     * @return string The generated value.
     * @throws Exception
     */
    public function setSluggedValue($slugAttribute, $sourceAttributes, $maxLength = 240)
    {
        if (!isset($this->{$slugAttribute}) || !strlen($this->{$slugAttribute})) {
            if (!is_array($sourceAttributes)) {
                $sourceAttributes = [$sourceAttributes];
            }

            $slugArr = [];
            foreach ($sourceAttributes as $attribute) {
                $slugArr[] = $this->getSluggableSourceAttributeValue($attribute);
            }

            $slug = implode(' ', $slugArr);
            $slug = substr($slug, 0, $maxLength);
            $slug = Str::slug($slug, $this->getSluggableSeparator());
        } else {
            $slug = $this->{$slugAttribute};
        }

        if (empty($slug)) {
            throw new Exception('Slug attribute [$slugAttribute] can not be empty.');
        }

        return $this->{$slugAttribute} = $this->getSluggableUniqueAttributeValue($slugAttribute, $slug);
    }

    /**
     * Ensures a unique attribute value, if the value is already used a counter suffix is added.
     *
     * @param string $name The database column name.
     * @param value $value The desired column value.
     *
     * @return string A safe value that is unique.
     */
    protected function getSluggableUniqueAttributeValue($name, $value)
    {
        $keyName = $this->getKeyName();
        $keyValue = $this->$keyName;

        $separator = $this->getSluggableSeparator();

        // Remove any existing suffixes
        $_value = preg_replace('/' . preg_quote($separator) . '+$/', '', trim($value));

        // If this model already have a slug that matches the requirements, then return that slug
        $current = $this->newQuery()->whereRaw("{$name} RLIKE '{$_value}(-[0-9]*)?$'")->where($keyName,
            $keyValue)->first();
        if ($current) {
            return $current->{$name};
        }

        // Get the latest slug matching the requirements to ensure that it is unique
        $latestSlug = $this->newQuery()->whereRaw("{$name} RLIKE '{$_value}(-[0-9]*)?$'")->latest($name)->pluck($name);
        if ($latestSlug) {
            if ($latestSlug == $_value) {
                return $_value . $separator . 1;
            }

            $pieces = explode('-', $latestSlug);
            $number = intval(end($pieces));

            return $_value . $separator . ($number + 1);
        }

        return $_value;
    }

    /**
     * Get an attribute relation value using dotted notation.
     * Eg: author.name.
     *
     * @return mixed
     */
    protected function getSluggableSourceAttributeValue($key)
    {
        if (strpos($key, '.') === false) {
            return $this->getAttribute($key);
        }
        $keyParts = explode('.', $key);
        $value = $this;
        foreach ($keyParts as $part) {
            if (!isset($value[$part])) {
                return;
            }
            $value = $value[$part];
        }

        return $value;
    }

    /**
     * Override the default slug separator.
     *
     * @return string
     */
    public function getSluggableSeparator()
    {
        return defined('static::SLUG_SEPARATOR') ? static::SLUG_SEPARATOR : '-';
    }
}