<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

enum MessageType: string {
	case State = 'state';
	case Error = 'error';
}
