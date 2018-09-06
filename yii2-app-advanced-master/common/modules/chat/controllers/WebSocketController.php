<?php

namespace common\modules\chat\controllers;

use yii\console\Controller;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use common\modules\chat\components\Chat;

/**
 * WebSocket controller for the `chat` module
 */
class WebSocketController extends Controller
{
    public function actionIndex()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );
        echo 'Привет' . PHP_EOL;
        $server->loop->addPeriodicTimer(10, function () {
            echo date('H:i:s'. PHP_EOL);
        });
        $server->run();
    }
}
