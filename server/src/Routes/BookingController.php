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
use Elephox\Templar\Foundation\Separator;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Foundation\Verbatim;
use Elephox\Templar\Length;
use Elephox\Templar\MainAxisAlignment;
use Elephox\Templar\Templar;
use Elephox\Web\Routing\Attribute\Controller;
use Elephox\Web\Routing\Attribute\Http\Get;
use ErrorException;
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
					new Center(
						new Column(
							children: [
							new Verbatim(
								<<<HTML
<select php-value="type" php-watch>
	<option value="one-way">One-Way</option>
	<option value="return">Return</option>
</select>
HTML
							),
							new Separator(),
							new LinkButton(new Text("Home"), "/", rank: ColorRank::Secondary,),
						],
							mainAxisAlignment: MainAxisAlignment::Center,
							crossAxisAlignment: CrossAxisAlignment::Center,
							shrinkWrap: true,
							gap: Length::inPx(20),
						),
					),
					"booking"
				)
			);
	}
}