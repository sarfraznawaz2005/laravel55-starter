<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2017
 * Time: 12:30 PM
 */

namespace Modules\Core\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Crudable;

class CoreController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use Crudable;

    const ADD_MESSAGE = 'Added Successfully!';
    const DELETE_MESSAGE = 'Deleted Successfully!';
    const UPDATE_MESSAGE = 'Updated Successfully!';

    public function __construct()
    {
        // any common stuff that will be available in whole app
    }
}
