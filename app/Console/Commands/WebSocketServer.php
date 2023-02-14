<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//websocket library IoServer class
use Ratchet\Server\IoServer;
//websocket library httpserver class
use Ratchet\Http\HttpServer;
//websocket library Web socket Server class
use Ratchet\WebSocket\WsServer;
//websocket library factory class
use React\EventLoop\Factory;

use App\Http\Controllers\SocketController;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;

        //setup the server
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketController()
                )
                ),
                8090
        );

        $server->run();
    }
}
