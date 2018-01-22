<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2017
 * Time: 12:30 PM
 */

namespace Modules\Core\Traits;

use Redirect;

trait Crudable
{
    public $tab = '';

    /**
     * Check whether logged user owns model record.
     *
     * Seems to be much simpler approach than using Laravel Gates or Policies.
     *
     * @param $model
     * @param string $userField
     * @return bool
     */
    public function isOwner($model, $userField = 'user_id')
    {
        if ($model->$userField == user()->id) {
            return true;
        }

        abort(404);

        return false;
    }

    /**
     * create a record and optionally redirect back
     *
     * @param $model
     * @param array $data
     * @param bool $redirectBack
     * @return mixed
     */
    public function createRecord($model, $data = [], $redirectBack = true)
    {
        if ($data) {
            $result = $model->save($data);
        } else {
            $result = $model->save();
        }

        if (!$result) {
            return $this->response($redirectBack, $model);
        }

        return $this->response($redirectBack, null, 'Added Successfully!');
    }

    /**
     * update a record and optionally redirect back
     *
     * @param $model
     * @param bool $redirectBack
     * @return mixed
     */
    public function updateRecord($model, $redirectBack = true)
    {
        $model->forceEntityHydrationFromInput = true;

        if (!$model->save()) {
            return $this->response($redirectBack, $model);
        }

        return $this->response($redirectBack, null, 'Updated Successfully!');
    }

    /**
     * deletes a record and optionally redirect back
     *
     * @param $model
     * @param bool $redirectBack
     * @return mixed
     */
    public function deleteRecord($model, $redirectBack = true)
    {
        if (!$model->delete($model)) {
            return $this->response($redirectBack, $model);
        }

        return $this->response($redirectBack, null, 'Deleted Successfully!');
    }

    /**
     * @param $redirectBack
     * @param $model
     * @param $message
     * @return mixed
     */
    protected function response($redirectBack, $model, $message = '')
    {
        if ($model) {
            if (count($model->errors())) {
                if ($redirectBack) {
                    return Redirect::back()->withInput($model->toArray())->withErrors($model->errors())->with('selected_tab',
                        $this->tab);
                }

                // in case of ajax, etc
                return $model->errors();
            }
        }

        if ($redirectBack) {
            if ($message) {
                flash($message, 'success');
                //alert()->success($message, 'Success')->autoclose(3000);
            }

            return Redirect::back()->with('selected_tab', $this->tab);
        }

        // in case of ajax, etc
        return true;
    }
}