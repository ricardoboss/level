<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Routes;

use Elephox\Http\Contract\ResponseBuilder;
use Elephox\Http\Response;
use Elephox\Http\ResponseCode;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Verbatim;
use Elephox\Templar\Templar;
use Elephox\Web\Routing\Attribute\Controller;
use Elephox\Web\Routing\Attribute\Http\Get;
use RicardoBoss\Level\Views\InlineTemplarRenderer;

#[Controller("")]
class WebRoutes {
	/**
	 * @throws \ErrorException
	 */
	#[Get]
	public function converter(Templar $templar): ResponseBuilder {
		return Response::build()->responseCode(ResponseCode::OK)->htmlBody(
				InlineTemplarRenderer::render(
					$templar,
					new Center(
						new Verbatim(
							<<<HTML
<input type="number" php-value="celsius" php-watch>°C
<input type="number" php-value="fahrenheit" php-watch>°F
HTML
						),
					),
					"converter"
				),
			);
	}

	/**
	 * @throws \ErrorException
	 */
	#[Get]
	public function counter(Templar $templar): ResponseBuilder {
		return Response::build()->responseCode(ResponseCode::OK)->htmlBody(
				InlineTemplarRenderer::render(
					$templar,
					new Center(
						new Verbatim(
							<<<HTML
<input type="number" readonly php-value="counter">
<button php-click="increment">Increment</button>
HTML
						),
					),
					"counter"
				),
			);
	}
}
