<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

class CounterState implements StateInterface {
	public function __construct(
		public int $counter = 0
	) {}
}
