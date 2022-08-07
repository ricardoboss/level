<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

enum FlightType: string {
	case OneWay = 'one-way';
	case Return = 'return';
}
