<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

class ConverterApplication extends StateApplication {
	protected function initializeState(): StateInterface {
		return new ConverterState();
	}

	protected function modifyState(StateInterface $state, string $action, array $params): void {
		assert($state instanceof ConverterState);

		switch ($action) {
			case 'change':
				switch ($params['field']) {
					case 'celsius':
						$state->celsius = (float)$params['value'];
						$state->fahrenheit = $state->celsius * (9 / 5) + 32;
						break;
					case 'fahrenheit':
						$state->fahrenheit = (float)$params['value'];
						$state->celsius = ($state->fahrenheit - 32) * (5 / 9);
						break;
				}
				break;
		}
	}
}
