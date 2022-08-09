<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket\Apps;

use RicardoBoss\Level\WebSocket\CounterState;
use RicardoBoss\Level\WebSocket\StateApplication;
use RicardoBoss\Level\WebSocket\StateInterface;

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
