<?php
/**
 * Created by PhpStorm.
 * User: Sarfaraz
 * Date: 2/12/2018
 * Time: 4:03 PM
 */

namespace Modules\Core\Facades;

use Config;
use Ratchet\Client;

class Socket
{
    /**
     * Get the registered name of the component.
     *
     * @param array $data
     * @param string $route
     */
    public static function send(array $data, $route = 'socket')
    {
        $config = config('socket');

        Client\connect('ws://' . $config['httpHost'] . ':' . $config['port'] . '/' . $route)
            ->then(function ($conn) use ($data) {
                $conn->send(json_encode($data));
                $conn->close();
            });
    }
}
