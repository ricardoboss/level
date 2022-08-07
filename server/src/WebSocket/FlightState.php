<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

class FlightState implements StateInterface {
	public function __construct(
		public FlightType $type,
		public string $departure,
		public string $arrival,
		public bool $arrivalDisabled = false,
		public bool $departureValid = false,
		public bool $arrivalValid = false,
		public bool $bookButtonDisabled = false,
	) {}

	public function jsonSerialize(): array {
		return [
			'type' => $this->type->value,
			'departure' => $this->departure,
			'arrival' => $this->arrival,
			'arrivalDisabled' => $this->arrivalDisabled,
			'departureValid' => $this->departureValid,
			'arrivalValid' => $this->arrivalValid,
			'bookButtonDisabled' => $this->bookButtonDisabled,
		];
	}
}
