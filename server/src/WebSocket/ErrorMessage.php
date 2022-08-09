<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

use JsonSerializable;
use Throwable;

class ErrorMessage implements JsonSerializable {
	public function __construct(protected readonly ?Throwable $error) {}

	public function jsonSerialize(): array {
		$payload = [];
		if ($this->error !== null) {
			$payload = [
				'message' => $this->error->getMessage(),
				'code' => $this->error->getCode(),
				'trace' => $this->error->getTraceAsString(),
			];
		}

		return [
			'type' => MessageType::Error,
			'payload' => $payload,
		];
	}
}