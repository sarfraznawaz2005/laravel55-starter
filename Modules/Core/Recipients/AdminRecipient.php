<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/29/2017
 * Time: 9:47 PM
 */

//$recipient = new AdminRecipient();
//$recipient->notify(new AdminAlert());

namespace Modules\Core\Recipients;

class AdminRecipient extends Recipient
{

    public function __construct()
    {
        $this->email = config('ADMIN_EMAIL');
    }

}