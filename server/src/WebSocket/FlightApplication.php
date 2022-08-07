<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

use DateTime;

class FlightApplication extends StateApplication {
	protected function initializeState(): StateInterface {
		return new FlightState(FlightType::OneWay, new DateTime(), new DateTime());
	}
}
