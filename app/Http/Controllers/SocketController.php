<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Web socket message component interface class
use Ratchet\MessageComponentInterface;
//Web socket connection interface class
use Ratchet\ConnectionInterface;
use App\Models\User;
use App\Models\Chat;
use App\Models\Chat_request;
use Auth;

class SocketController extends Controller implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        //this will store connection under this variable
        $this->clients = new \SplObjectStorage;
    }

    // this function will be called when new connection request has been received
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring, $queryarray);

        if(isset($queryarray['token']))
        {
            User::where('token', $queryarray['token'])->update(['connection_id' => $conn->resourceId]);
        }
    }

    //onMessage will be called when message has been sent
    public function onMessage(ConnectionInterface $conn, $msg)
    {

    }

    //onClose will be called when web socket connection has been closed
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring, $queryarray);

        if(isset($queryarray['token']))
        {
            User::where('token', $queryarray['token'])->update(['connection_id' => 0]);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occured: {$e->getMessage()} \n";
        $conn->close();
    }
}
