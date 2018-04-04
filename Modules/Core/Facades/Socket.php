<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 2/12/2018
 * Time: 4:03 PM
 */

namespace Modules\Core\Facades;

use Carbon\Carbon;

class Socket
{
    /**
     * Get the registered name of the component.
     *
     * @param array $data
     * @return bool
     */
    public static function send(array $data)
    {
        if (!config('core.settings.enable_socket')) {
            return false;
        }

        if (empty($data)) {
            return false;
        }

        try {

            $client = new \vakata\websocket\Client(static::getSocketUrl());

            $data['time'] = Carbon::now()->toTimeString();

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
