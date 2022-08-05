<?php
declare(strict_types=1);

use Bloatless\WebSocket\Application\StatusApplication;
use Bloatless\WebSocket\Server as WebSocketServer;
use Elephox\Configuration\Contract\Configuration;
use Elephox\Templar\DocumentMeta;
use Elephox\Templar\Templar;
use Elephox\Web\Routing\RequestRouter;
use Elephox\Web\WebApplicationBuilder;
use RicardoBoss\Level\Routes\WebRoutes;
use RicardoBoss\Level\WebSocket\UIApp;

require __DIR__ . '/vendor/autoload.php';

$builder = WebApplicationBuilder::create();

$builder->services->addTransient(UIApp::class, UIApp::class, fn () => UIApp::getInstance());

$builder->services->addSingleton(WebSocketServer::class, implementationFactory: function (
	Configuration $config,
	UIApp $uiApp,
) {
	$server = new WebSocketServer($config['server:host'], $config['server:port']);

	$server->setCheckOrigin(false);

	$server->registerApplication('status', StatusApplication::getInstance());
	$server->registerApplication('ui', $uiApp);

	return $server;
});

$builder->services->addSingleton(Templar::class, implementationFactory: function() {
	return new Templar(
		new DocumentMeta(
			"level"
		),
	);
});

$builder->setRequestRouterEndpoint();
$builder->service(RequestRouter::class)->loadFromClass(WebRoutes::class);

return $builder->build();
