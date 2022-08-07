<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Views;

use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

class InlineTemplarRenderer {
	/**
	 * @throws \ErrorException
	 */
	public static function render(Templar $templar, Widget $content, string $scriptName): string {
		$app = new App($content, $scriptName);
		$style = $templar->renderStyle($app);
		$templar->context->meta->styles[] = $style;
		return $templar->render($app);
	}
}
