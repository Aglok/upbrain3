<?php

namespace App\Console\Commands;

use App\Services\WebSocket\GameDuel;
use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class GameDuelServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game_duel:start';

    /**
     * The console command description.
     *
     * @var string
     */
    
    protected $description = 'Запустать сервер для игры дуэли';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Запущен сервер!');
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new GameDuel()
                )
            ),
            8080
        );

        $server->run();
    }
}
