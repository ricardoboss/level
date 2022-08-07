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

	protected function modifyState(StateInterface $state, string $action, mixed $params): void {
		assert($state instanceof CounterState);

		switch ($action) {
			case 'click':
				$state->counter++;
				break;
		}
	}
}
