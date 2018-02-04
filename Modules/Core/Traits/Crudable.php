<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2017
 * Time: 12:30 PM
 */

namespace Modules\Core\Traits;

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
     * @param bool $abort
     * @return bool
     */
    public function isOwner($model, $userField = 'user_id', $abort = true)
    {
        if ($model->$userField == user()->id) {
            return true;
        }

        if ($abort) {
            abort(404);
        }

        return false;
    }

    /**
     * create a record and optionally redirect back
     *
     * @param $model
     * @param bool $redirectBack
     * @return mixed
     */
    public function createRecord($model, $redirectBack = true)
    {
        $result = $model->save(request()->all());

        if (!$result) {
            return $this->response($redirectBack, $model);
        }

        return $this->response($redirectBack, null, self::ADD_MESSAGE);
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
        if (!$model->save()) {
            return $this->response($redirectBack, $model);
        }

        return $this->response($redirectBack, null, self::UPDATE_MESSAGE);
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

        return $this->response($redirectBack, null, self::DELETE_MESSAGE);
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

            if (count($model->getErrors())) {
                if ($redirectBack) {
                    return redirect()->back()->withInput($model->toArray())
                        ->withErrors($model->getErrors())
                        ->with('selected_tab', $this->tab);
                }

                // in case of ajax, etc
                return $model->getErrors();
            }
        }

        if ($redirectBack) {
            if ($message) {
                flash($message, 'success');
                //alert()->success($message, 'Success')->autoclose(3000);
            }

            return redirect()->back()->with('selected_tab', $this->tab);
        }

        // in case of ajax, etc
        return true;
    }
}