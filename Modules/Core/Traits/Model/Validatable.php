<?php

namespace Modules\Core\Traits\Model;

use Validator;

trait Validatable
{
    public $errors;

    public function isValid($data = [], $rules = [])
    {
        if (empty($data)) {
            $data = $this->toArray();
        }

        if (empty($rules)) {
            $rules = $this->rules;
        }

        if (empty($rules)) {
            return true;
        }

        $v = Validator::make($data, $rules);

        if ($v->fails()) {
            $this->errors = $v->messages();
            return false;
        }

        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}
