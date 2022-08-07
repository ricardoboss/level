<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket;

enum ActionType: string {
	case Click = 'click';
	case Change = 'change';
}
