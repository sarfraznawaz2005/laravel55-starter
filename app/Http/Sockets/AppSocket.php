<?php

namespace App\Http\Sockets;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Orchid\Socket\BaseSocketListener;
use Ratchet\ConnectionInterface;

class AppSocket extends BaseSocketListener
{
    /**
     * Current clients.
     *
     * @var \SplObjectStorage
     */
    protected $clients;

    protected $userList;

    /**
     * AppSocket constructor.
     */
    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        //take user id
        $userId = $this->getUserFromSession($conn);

        //Create a list of users connected to the server
        $this->userList[] = $userId;

        //We tell everything that happened
        echo "New connection! user_id = ({$userId})\n";
    }

    /**
     * @param ConnectionInterface $from
     * @param $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    public function getUserFromSession($conn)
    {
        // Create a new session handler for this client
        $session = (new SessionManager(App::getInstance()))->driver();

        // Get the cookies
        $cookies = $conn->WebSocket->request->getCookies();

        // Get the laravel's one
        $laravelCookie = urldecode($cookies[Config::get('session.cookie')]);

        // get the user session id from it
        $idSession = Crypt::decrypt($laravelCookie);

        // Set the session id to the session handler
        $session->setId($idSession);

        // Bind the session handler to the client connection
        $conn->session = $session;
        $conn->session->start();

        //We take the user from a session
        $userId = $conn->session->get(Auth::getName());

        return $userId;
    }
}
