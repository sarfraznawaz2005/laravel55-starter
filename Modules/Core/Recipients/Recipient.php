<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/29/2017
 * Time: 9:45 PM
 */

namespace Modules\Core\Recipients;

use Illuminate\Notifications\Notifiable;

abstract class Recipient
{

    use Notifiable;

    protected $email;
}