<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket\Apps;

use RicardoBoss\Level\WebSocket\BookingState;
use RicardoBoss\Level\WebSocket\FlightType;
use RicardoBoss\Level\WebSocket\StateApplication;
use RicardoBoss\Level\WebSocket\StateInterface;

class BookingApplication extends StateApplication {
	protected function initializeState(): StateInterface {
		return new BookingState(FlightType::OneWay, date("c"), date("c"));
	}

	public function onTypeChanged(BookingState $state, string $value) {
		$state->type = FlightType::from($value);
	}
}
