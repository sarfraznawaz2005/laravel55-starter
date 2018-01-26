<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2017
 * Time: 12:30 PM
 */

namespace Modules\Core\Http\Controllers;

use function appName;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Crudable;
use Meta;
use function request;

class CoreController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use Crudable;

    const ADD_MESSAGE = 'Added Successfully!';
    const DELETE_MESSAGE = 'Deleted Successfully!';
    const UPDATE_MESSAGE = 'Updated Successfully!';

    // any common stuff that will be available in whole app
    public function __construct()
    {
        # Default meta settings
        Meta::set('title', appName());
        Meta::set('description', appName());
        Meta::set('site_name', appName());
        Meta::set('url', request()->url());
        Meta::set('locale', 'en_EN');
        Meta::set('robots', 'index,follow');
    }
}
