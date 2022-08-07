<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Middleware;

use Elephox\Http\Contract\ResponseBuilder;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Templar;
use Elephox\Web\Middleware\DefaultExceptionHandler;
use RicardoBoss\Level\Views\App;
use RicardoBoss\Level\Views\InlineTemplarRenderer;

class ProductionExceptionHandler extends DefaultExceptionHandler {
	public function __construct(
		private readonly Templar $templar,
	) {}

	protected function setResponseBody(ResponseBuilder $response): ResponseBuilder {
		return $response->htmlBody(
			InlineTemplarRenderer::render(
				$this->templar,
				new App(new Center(new Text("Not Found")))
			)
		);
	}
}
