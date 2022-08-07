<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

use Bloatless\WebSocket\Application\ApplicationInterface;
use Bloatless\WebSocket\Connection;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @template TState of StateInterface
 */
abstract class StateApplication implements ApplicationInterface, LoggerAwareInterface {
	/**
	 * @return TState
	 */
	abstract protected function initializeState(): StateInterface;

	public static function getInstance(): ApplicationInterface {
		return new static();
	}

	/**
	 * @var array<string, TState>
	 */
	protected array $states = [];

	protected LoggerInterface $logger;

	public function __construct() {
		$this->logger = new NullLogger();
	}

	public function setLogger(LoggerInterface $logger): void {
		$this->logger = $logger;
	}

	/**
	 * @throws \JsonException
	 */
	public function onConnect(Connection $connection): void {
		$this->sendState($connection);
	}

	public function onDisconnect(Connection $connection): void {
		$this->dropState($connection);
	}

	public function onIPCData(array $data): void {
		throw new \RuntimeException('Not implemented.');
	}

	/**
	 * @throws \JsonException
	 */
	public function onData(string $data, Connection $client): void {
		$decoded =
			json_decode(
				$data,
				true,
				512,
				JSON_THROW_ON_ERROR
			);
		if (!isset($decoded['action'], $decoded['payload']) ||
			!is_string($decoded['action']) ||
			!is_array($decoded['payload'])) {
			return;
		}

		switch ($decoded['action']) {
			case ActionType::Click->value:
				$this->onClick(
					$client,
					$decoded['payload']
				);
				break;
			case ActionType::Change->value:
				$this->onChange(
					$client,
					$decoded['payload']
				);
				break;
			default:
				return;
		}

		$this->sendState($client);
	}

	/**
	 * @param Connection $client
	 * @return TState
	 */
	protected function getState(Connection $client): StateInterface {
		$clientId = $client->getClientId();
		$state = @$this->states[$clientId];

		if (!$state) {
			$state = $this->initializeState();
			$this->states[$clientId] = $state;
		}

		return $state;
	}

	/**
	 * @param Connection $client
	 * @return void
	 */
	protected function dropState(Connection $client): void {
		unset($this->states[$client->getClientId()]);
	}

	protected function onClick(Connection $client, array $payload): void {
		$clickId = $payload['clickId'];
		$method = 'on' . ucfirst($clickId) . 'Clicked';

		if (!method_exists($this, $method)) {
			$this->logger->warning('Received onClick event for click id {clickId} but no method {method} exists.', [
				'clickId' => $clickId,
				'method' => $method,
			]);

			return;
		}

		$state = $this->getState($client);
		$this->$method($state, $payload);
	}

	protected function onChange(Connection $client, array $payload): void {
		$changeId = $payload['changeId'];
		$method = 'on' . ucfirst($changeId) . 'Changed';

		if (!method_exists($this, $method)) {
			$this->logger->warning('Received onChange event for change id {changeId} but no method {method} exists.', [
				'changeId' => $changeId,
				'method' => $method,
			]);

			return;
		}

		$state = $this->getState($client);
		$this->$method($state, $payload);
	}

	/**
	 * @throws \JsonException
	 */
	protected function sendState(Connection $client): void {
		$client->send(
			json_encode(
				new StateMessage($this->getState($client)),
				JSON_THROW_ON_ERROR
			)
		);
	}
}
