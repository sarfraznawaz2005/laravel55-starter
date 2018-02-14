<?php
/**
 * Created by PhpStorm.
 * User: Sarfaraz
 * Date: 2/12/2018
 * Time: 4:03 PM
 */

namespace Modules\Core\Facades;

class Socket
{
    /**
     * Get the registered name of the component.
     *
     * @param array $data
     */
    public static function send(array $data)
    {
        try {

            $client = new \vakata\websocket\Client(static::getSocketUrl());

            $client->send(json_encode($data));

        } catch (\Exception $e) {
        }
    }

    public static function getSocketUrl($route = 'socket'): string
    {
        $config = config('socket');

        return 'ws://' . $config['httpHost'] . ':' . $config['port'];
    }
}
