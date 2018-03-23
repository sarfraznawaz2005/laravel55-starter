<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Modules\Core\Facades\Socket;

class SocketServer extends Command
{
    protected $name = 'socket_serve';
    protected $description = 'Starts websocket server.';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        set_time_limit(0);

        # keep script running always
        ignore_user_abort(true);

        try {

            $server = new \vakata\websocket\Server(Socket::getSocketUrl());

            $server->onMessage(function ($sender, $message, $server) {
                foreach ($server->getClients() as $client) {
                    if ((int)$sender['socket'] !== (int)$client['socket']) {

                        $data = json_decode($message);

                        // don't show notification to originator/same user
                        if (auth()->check() && (int)user()->id !== (int)$data->user_id) {
                            $server->send($client['socket'], $message);
                        } else {
                            $server->send($client['socket'], $message);
                        }
                    }
                }
            });

            $server->run();

        } catch (\Exception $e) {
        }
    }
}
