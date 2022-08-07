<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

class ConverterState implements StateInterface {
	public function __construct(
		public float $celsius = 0.0,
		public float $fahrenheit = 0.0
	) {}

	public function jsonSerialize(): array {
		return [
			'celsius' => $this->celsius,
			'fahrenheit' => $this->fahrenheit,
		];
	}
}
