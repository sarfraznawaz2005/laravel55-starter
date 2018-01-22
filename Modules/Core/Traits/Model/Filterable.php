<?php

namespace Modules\Core\Traits\Model;

/*
 * Usage Example:

class Page extends Model
{
    use Filterable;

    protected $fillable = [
        'title',
        'status',
        'created_at',
    ];

    protected $filterable = [
        'title',
        'created_after'
    ];

    public function scopeCreatedAfter($query, $time)
    {
        return $query->where('created_at', '>', $time);
    }
}

Page::filter(['title' => 'Cool page'])->first(); // equals to where('title', 'Cool page')
Page::filter(['status' => ['new', 'active'])->get() // equals to whereIn('status', ['new', 'active'])
Page::filter(['created_after' => '2017-01-01'])->get() // equals to createdAfter('2017-01-01') (notice our scope in Page class)

supports filters with multiple keys:

Page::filter(['title' => 'Cool page', 'status' => 'active'])->first()

*/


trait Filterable
{
    public function scopeFilter($query, array $filterData = [])
    {
        foreach ($filterData as $key => $value) {
            if (!$this->isFilterable($key)) {
                throw new \Exception("[$key] is not allowed for filtering");
            }

            if (is_null($value) || $value === '') {
                continue;
            }

            $scopeName = ucfirst(camel_case($key));

            if (method_exists($this, 'scope' . $scopeName)) {
                $query->$scopeName($value);
            } else {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }
    }

    protected function isFilterable($key)
    {
        $filterable = $this->filterable ?: [];

        return in_array($key, $filterable);
    }
}