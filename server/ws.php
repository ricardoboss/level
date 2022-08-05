<?php
declare(strict_types=1);

/** @var \Elephox\Web\WebApplication $app */

use Bloatless\WebSocket\Server as WebSocketServer;

$app = require __DIR__ . '/bootstrap.php';

$server = $app->services->requireService(WebSocketServer::class);
$server->run();
