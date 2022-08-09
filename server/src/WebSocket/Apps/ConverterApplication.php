<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket\Apps;

use RicardoBoss\Level\WebSocket\ConverterState;
use RicardoBoss\Level\WebSocket\StateApplication;
use RicardoBoss\Level\WebSocket\StateInterface;

class ConverterApplication extends StateApplication {
	protected function initializeState(): StateInterface {
		return new ConverterState();
	}

	public function onCelsiusChanged(ConverterState $state, string $value) {
		$state->celsius = (float) $value;
		$state->fahrenheit = $state->celsius * (9.0 / 5.0) + 32.0;
	}

	public function onFahrenheitChanged(ConverterState $state, string $value) {
		$state->fahrenheit = (float) $value;
		$state->celsius = ($state->fahrenheit - 32.0) * (5.0 / 9.0);
	}
}
