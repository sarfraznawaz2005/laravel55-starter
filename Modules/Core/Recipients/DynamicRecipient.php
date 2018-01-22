<?php
/**
 * Created by PhpStorm.
 * User: Loyal
 * Date: 1/29/2017
 * Time: 9:49 PM
 */

//$recipient = new DynamicRecipient('email@email.com');
//$recipient->notify(new GeneralNotification());

namespace Modules\Core\Recipients;

class DynamicRecipient extends Recipient
{

    public function __construct($email)
    {
        $this->email = $email;
    }

}