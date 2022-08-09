<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

use Bloatless\WebSocket\Application\ApplicationInterface;
use Elephox\Autoloading\Composer\NamespaceLoader;
use Elephox\DI\Contract\Resolver;

class WebsocketAppProvider {
	public function __construct(
		private readonly Resolver $resolver,
	) {}

	/**
	 * @return iterable<string, ApplicationInterface>
	 */
	public function getApps(): iterable {
		$apps = [];

		NamespaceLoader::iterateNamespace("RicardoBoss\\Level\\WebSocket\\Apps\\", function (string $className) use (&$apps) {
			$instance = $this->resolver->instantiate($className);

			$key = substr($className, strrpos($className, "\\") + 1);
			$key = str_replace("Application", "", $key);
			$key = strtolower($key);

			$apps[$key] = $instance;
		});

		return $apps;
	}
}
