<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Routes;

use Elephox\Http\Contract\ResponseBuilder;
use Elephox\Http\Response;
use Elephox\Http\ResponseCode;
use Elephox\Templar\CrossAxisAlignment;
use Elephox\Templar\Foundation\Column;
use Elephox\Templar\Foundation\LinkButton;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Length;
use Elephox\Templar\MainAxisAlignment;
use Elephox\Templar\Templar;
use Elephox\Templar\TextStyle;
use Elephox\Web\Routing\Attribute\Controller;
use Elephox\Web\Routing\Attribute\Http\Get;
use ErrorException;
use RicardoBoss\Level\WebSocket\StateApplication;
use RicardoBoss\Level\WebSocket\WebsocketAppProvider;
use RicardoBoss\Level\Widgets\InlineTemplarRenderer;

#[Controller("")]
class IndexController {
	/**
	 * @throws ErrorException
	 */
	#[Get]
	public function index(Templar $templar, WebsocketAppProvider $appProvider): ResponseBuilder {
		$links = [];
		foreach ($appProvider->getApps() as $key => $app) {
			if (!$app instanceof StateApplication) {
				continue;
			}

			$links[] = new LinkButton(new Text(ucfirst($key)), "/$key");
		}

		return Response::build()->responseCode(ResponseCode::OK)->htmlBody(
			InlineTemplarRenderer::render(
				$templar,
				new Column(
					children: [
						new Text(
							"Level Examples",
							style: new TextStyle(size: Length::inRem(2))
						),
						...$links,
					],
					mainAxisAlignment: MainAxisAlignment::Center,
					crossAxisAlignment: CrossAxisAlignment::Center,
					gap: Length::inPx(20),
				),
				null
			),
		);
	}
}
