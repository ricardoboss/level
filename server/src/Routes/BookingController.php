<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Routes;

use Elephox\Http\Contract\ResponseBuilder;
use Elephox\Http\Response;
use Elephox\Http\ResponseCode;
use Elephox\Templar\Templar;
use Elephox\Web\Routing\Attribute\Controller;
use Elephox\Web\Routing\Attribute\Http\Get;
use ErrorException;
use RicardoBoss\Level\WebSocket\Apps\BookingApplication;
use RicardoBoss\Level\Widgets\InlineTemplarRenderer;

#[Controller]
class BookingController {
	/**
	 * @throws ErrorException
	 */
	#[Get]
	public function index(Templar $templar): ResponseBuilder {
		return Response::build()
			->responseCode(ResponseCode::OK)
			->htmlBody(
				InlineTemplarRenderer::render(
					$templar,
					(new BookingApplication())->render((new BookingApplication())->initializeState()),
					"booking"
				)
			);
	}
}
