<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Routes;

use Elephox\Http\Contract\ResponseBuilder;
use Elephox\Http\Response;
use Elephox\Http\ResponseCode;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Foundation\Verbatim;
use Elephox\Templar\Templar;
use Elephox\Templar\Widget;
use Elephox\Web\Routing\Attribute\Controller;
use Elephox\Web\Routing\Attribute\Http\Get;
use RicardoBoss\Level\Views\App;
use RicardoBoss\Level\Views\InlineTemplarRenderer;

#[Controller("")]
class WebRoutes {
	/**
	 * @throws \ErrorException
	 */
	#[Get]
	public function index(Templar $templar): ResponseBuilder {
		return Response::build()->responseCode(ResponseCode::OK)->htmlBody(
				InlineTemplarRenderer::render(
					$templar,
					new Center(
						new Verbatim(
							<<<HTML
	<input type="number" php-value="celsius" php-watch>°C
	<input type="number" php-value="fahrenheit" php-watch>°F
	<script>
	function updateValues(data) {
		for (const key in data) {
			document.querySelectorAll('[php-value="' + key + '"]').forEach(e => e.value = data[key])
		}
	}

	const uiSocket = new WebSocket('ws://localhost:8080/converter')
	document.querySelectorAll('[php-onclick]').forEach(e => e.addEventListener('click', event => {
		uiSocket.send(JSON.stringify({action: 'click', data: event.target.getAttribute('php-onclick')}))
	}))
	document.querySelectorAll('[php-watch]').forEach(e => e.addEventListener('change', event => {
		uiSocket.send(JSON.stringify({action: 'change', data: {field: event.target.getAttribute('php-value'), value: event.target.value}}))
	}))
	uiSocket.addEventListener('message', event => {
		const data = JSON.parse(event.data)
		if (data.action === 'state') {
			updateValues(data.data)
		}
	})
	</script>
	HTML
						),
					),
				)
			);
	}
}
