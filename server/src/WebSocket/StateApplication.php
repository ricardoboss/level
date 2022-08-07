<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

use Bloatless\WebSocket\Application\Application;
use Bloatless\WebSocket\Connection;

/**
 * @template TState of StateInterface
 */
abstract class StateApplication extends Application {
	/**
	 * @return TState
	 */
	abstract protected function initializeState(): StateInterface;

	abstract protected function modifyState(StateInterface $state, string $action, array $params): void;

	/**
	 * @var array<string, TState>
	 */
	protected array $states = [];

	/**
	 * @param Connection $client
	 * @return void
	 */
	protected function dropState(Connection $client): void {
		unset($this->states[$client->getClientId()]);
	}

	/**
	 * @param Connection $client
	 * @return TState
	 */
	protected function getState(Connection $client): StateInterface {
		return $this->states[$client->getClientId()];
	}

	public function onConnect(Connection $connection): void {
		$this->states[$connection->getClientId()] = $this->initializeState();

		$this->sendState($connection);
	}

	public function onDisconnect(Connection $connection): void {
		$this->dropState($connection);
	}

	public function onData(string $data, Connection $client): void {
		$action = $this->decodeData($data);

		$state = $this->getState($client);
		$this->modifyState($state, $action['action'], $action['data']);
		$this->sendState($client);
	}

	public function onIPCData(array $data): void {
		throw new \RuntimeException('Not implemented.');
	}

	protected function sendState(Connection $client): void {
		$client->send(
			$this->encodeData(
				'state',
				$this->getState($client)
			)
		);
	}
}
