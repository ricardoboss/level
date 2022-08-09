<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Commands;

use Bloatless\WebSocket\Application\StatusApplication;
use Bloatless\WebSocket\Server as WebSocketServer;
use Elephox\Console\Command\CommandInvocation;
use Elephox\Console\Command\CommandTemplateBuilder;
use Elephox\Console\Command\Contract\CommandHandler;
use Elephox\Files\Path;
use Psr\Log\LoggerInterface;
use RicardoBoss\Level\WebSocket\WebsocketAppProvider;

class WebsocketServeCommand implements CommandHandler {
	public function __construct(
		private readonly LoggerInterface $logger,
		private readonly WebsocketAppProvider $appProvider,
	) {}

	public function configure(CommandTemplateBuilder $builder): void {
		$builder->setName('websocket:serve')
			->setDescription('Serve the websocket server')
		;

		$builder->addArgument('host', true, 'localhost', 'The host to bind to');
		$builder->addArgument('port', true, 8080, 'The port to bind to');
	}

	public function handle(CommandInvocation $command): ?int {
		$host = $command->arguments->get('host')->value;
		$port = (int) $command->arguments->get('port')->value;

		$server = new WebSocketServer($host, $port, Path::join(sys_get_temp_dir(), 'phpwss.sock'));
		$server->setLogger($this->logger);
		$server->setCheckOrigin(false);

		$server->registerApplication('status', StatusApplication::getInstance());

		foreach ($this->appProvider->getApps() as $key => $app) {
			$server->registerApplication($key, $app);
			$this->logger->info("Registered application '$key' (" . get_debug_type($app) . ")");
		}

		$this->logger->info("Starting websocket server on ws://$host:$port", [
			'scheme' => 'ws',
			'host' => $host,
			'port' => $port,
		]);

		$server->run();

		return 0;
	}
}
