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

#[Controller("")]
class WebRoutes {
	/**
	 * @throws \ErrorException
	 */
	#[Get]
	public function index(Templar $templar): ResponseBuilder {
		return $this->render(
			$templar,
			new Center(
				new Verbatim(<<<HTML
<input type="text" readonly php-value="counter">
<button type="button" php-onclick="increment">Count</button>
<script>
const socket = new WebSocket('ws://localhost:8081/ui')
socket.addEventListener('message', event => {
	const data = JSON.parse(event.data)
	console.log(data)
	for (const key in data) {
		document.querySelector('[php-value="' + key + '"]').value = data[key]
	}
})
document.querySelector('[php-onclick]').addEventListener('click', event => {
	socket.send(JSON.stringify({type: 'onclick', name: event.target.getAttribute('php-onclick')}))
})
</script>
HTML),
			),
		);
	}

	/**
	 * @throws \ErrorException
	 */
	private function render(Templar $templar, Widget $content): ResponseBuilder {
		$app = new App($content);
		$style = $templar->renderStyle($app);
		$templar->context->meta->styles[] = $style;
		$body = $templar->render($app);

		return Response::build()->responseCode(ResponseCode::OK)->htmlBody($body);
	}
}
