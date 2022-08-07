<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

/**
 * @extends StateApplication<CounterState>
 */
class CounterApplication extends StateApplication {
	protected function initializeState(): StateInterface {
		return new CounterState();
	}

	public function onIncrementClicked(CounterState $state) {
		$state->counter++;
	}
}
