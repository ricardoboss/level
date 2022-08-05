<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

use Bloatless\WebSocket\Application\Application;
use Bloatless\WebSocket\Connection;

class UIApp extends Application {
	private array $clientStates = [];

	public function onConnect(Connection $connection): void {
		$this->clientStates[$connection->getClientId()] = [
			'counter' => 0,
		];
	}

	public function onDisconnect(Connection $connection): void {
		unset($this->clientStates[$connection->getClientId()]);
	}

	public function onData(string $data, Connection $client): void {
		$decoded = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
		$action = $decoded['type'];
		switch ($action) {
			case 'onclick':
				switch ($decoded['name']) {
					case 'increment':
					$this->clientStates[$client->getClientId()]['counter']++;
					break;
				}
				break;
		}
		$client->send(json_encode($this->clientStates[$client->getClientId()]));
	}

	public function onIPCData(array $data): void {
	}
}
