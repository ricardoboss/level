<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

use JsonSerializable;

class StateMessage implements JsonSerializable {
	public function __construct(
		public readonly StateInterface $state,
	) {}

	public function jsonSerialize(): array {
		return [
			'type' => MessageType::State,
			'payload' => $this->state,
		];
	}
}
