<?php
declare(strict_types=1);

use Elephox\Builder\Whoops\AddsWhoopsMiddleware;
use Elephox\Support\Contract\ExceptionHandler;
use Elephox\Templar\ColorScheme;
use Elephox\Templar\DocumentMeta;
use Elephox\Templar\Foundation\Colors;
use Elephox\Templar\Templar;
use Elephox\Web\Routing\RequestRouter;
use Elephox\Web\WebApplicationBuilder;
use RicardoBoss\Level\Middleware\ProductionExceptionHandler;
use RicardoBoss\Level\WebSocket\WebsocketAppProvider;

const APP_ROOT = __DIR__ . '/..';
require APP_ROOT . '/vendor/autoload.php';

class WebBuilder extends WebApplicationBuilder {
	use AddsWhoopsMiddleware;
}

$builder = WebBuilder::create();

if ($builder->environment->isDevelopment()) {
	$builder->addWhoops();
}
else {
	$builder->services->addSingleton(
		ExceptionHandler::class,
		ProductionExceptionHandler::class,
		fn (Templar $templar) => new ProductionExceptionHandler($templar)
	);

	$builder->pipeline->exceptionHandler($builder->service(ExceptionHandler::class));
}

$builder->services->addSingleton(
	Templar::class,
	implementationFactory: function () {
		return new Templar(
			new DocumentMeta(
				"level"
			),
			colorScheme: new ColorScheme(
				primary: Colors::Emerald()->lighten(0.25),
				secondary: Colors::Grayscale(0.7),
			),
		);
	}
);

$builder->services->addSingleton(WebsocketAppProvider::class);

$builder->setRequestRouterEndpoint();
$builder->service(RequestRouter::class)->loadFromNamespace("RicardoBoss\\Level\\Routes\\");

$app = $builder->build();
$app->run();
