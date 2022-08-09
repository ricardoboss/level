<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Routes;

use Elephox\Http\Contract\ResponseBuilder;
use Elephox\Http\Response;
use Elephox\Http\ResponseCode;
use Elephox\Templar\ColorRank;
use Elephox\Templar\CrossAxisAlignment;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Column;
use Elephox\Templar\Foundation\LinkButton;
use Elephox\Templar\Foundation\Row;
use Elephox\Templar\Foundation\Separator;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\InputType;
use Elephox\Templar\Length;
use Elephox\Templar\MainAxisAlignment;
use Elephox\Templar\Templar;
use Elephox\Templar\TextStyle;
use Elephox\Web\Routing\Attribute\Controller;
use Elephox\Web\Routing\Attribute\Http\Get;
use RicardoBoss\Level\Views\InlineTemplarRenderer;
use RicardoBoss\Level\Widgets\LevelInput;

#[Controller("")]
class IndexController {
	/**
	 * @throws \ErrorException
	 */
	#[Get]
	public function index(Templar $templar): ResponseBuilder {
		return Response::build()->responseCode(ResponseCode::OK)->htmlBody(
			InlineTemplarRenderer::render(
				$templar,
				new Column(
					children: [
						new Text(
							"Level Examples",
							style: new TextStyle(size: Length::inRem(2))
						),
						new LinkButton(
							new Text("Counter"),
							"/counter"
						),
						new LinkButton(
							new Text("Converter"),
							"/converter"
						),
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
