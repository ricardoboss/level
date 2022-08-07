<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

class ConverterApplication extends StateApplication {
	protected function initializeState(): StateInterface {
		return new ConverterState();
	}

	public function onCelsiusChanged(ConverterState $state, array $payload) {
		$state->celsius = (float) $payload['value'];
		$state->fahrenheit = $state->celsius * (9.0 / 5.0) + 32.0;
	}

	public function onFahrenheitChanged(ConverterState $state, array $payload) {
		$state->fahrenheit = (float) $payload['value'];
		$state->celsius = ($state->fahrenheit - 32.0) * (5.0 / 9.0);
	}
}
