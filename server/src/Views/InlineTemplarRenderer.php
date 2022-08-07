<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Views;

use Elephox\Http\Contract\ResponseBuilder;
use Elephox\Http\Response;
use Elephox\Http\ResponseCode;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;

class InlineTemplarRenderer {
	/**
	 * @throws \ErrorException
	 */
	public static function render(Templar $templar, Widget $content): string {
		$app = new App($content);
		$style = $templar->renderStyle($app);
		$templar->context->meta->styles[] = $style;
		return $templar->render($app);
	}
}
