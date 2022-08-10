<?php
declare(strict_types=1);

namespace RicardoBoss\Level\WebSocket\Apps;

use Elephox\Templar\ColorRank;
use Elephox\Templar\CrossAxisAlignment;
use Elephox\Templar\Foundation\Center;
use Elephox\Templar\Foundation\Column;
use Elephox\Templar\Foundation\LinkButton;
use Elephox\Templar\Foundation\Separator;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\Foundation\Verbatim;
use Elephox\Templar\InputType;
use Elephox\Templar\Length;
use Elephox\Templar\MainAxisAlignment;
use Elephox\Templar\Widget;
use RicardoBoss\Level\WebSocket\BookingState;
use RicardoBoss\Level\WebSocket\FlightType;
use RicardoBoss\Level\WebSocket\StateApplication;
use RicardoBoss\Level\WebSocket\StateInterface;
use RicardoBoss\Level\Widgets\LevelButton;
use RicardoBoss\Level\Widgets\LevelInput;

class BookingApplication extends StateApplication {
	public function initializeState(): StateInterface {
		return new BookingState(FlightType::OneWay, date("c"), date("c"));
	}

	public function render(StateInterface $state): Widget {
		assert($state instanceof BookingState);

		return new Center(
			new Column(
				children: [
					new Verbatim(
						<<<HTML
<select php-value="{$state->type->value}" php-watch>
	<option value="one-way">One-Way</option>
	<option value="return">Return</option>
</select>
HTML
					),
					new LevelInput(
						InputType::Text,
						"departure",
						true,
						value: $state->departure,
					),
					new LevelInput(
						InputType::Text,
						"arrival",
						true,
						disabled: $state->arrivalDisabled,
						value: $state->arrival,
					),
					new LevelButton(
						"book",
						new Text("Book"),
						disabled: $state->bookButtonDisabled,
					),
					new Separator(),
					new LinkButton(
						new Text("Home"),
						"/",
						rank: ColorRank::Secondary,
					),
				],
				mainAxisAlignment: MainAxisAlignment::Center,
				crossAxisAlignment: CrossAxisAlignment::Center,
				shrinkWrap: true,
				gap: Length::inPx(20),
			),
		);
	}

	public function onTypeChanged(BookingState $state, string $value) {
		$state->type = FlightType::from($value);
	}

	public function onBookClicked(): void {

	}
}
