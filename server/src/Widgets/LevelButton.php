<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Widgets;

use Elephox\Templar\BackgroundValue;
use Elephox\Templar\BorderRadius;
use Elephox\Templar\ButtonType;
use Elephox\Templar\ColorRank;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Foundation\Button;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class LevelButton extends Button {
	public function __construct(
		protected readonly string $onclick,
		?Widget $child,
		?BackgroundValue $background = null,
		?TextStyle $textStyle = null,
		?EdgeInsets $padding = null,
		?BorderRadius $borderRadius = null,
		ColorRank $rank = ColorRank::Primary,
		ButtonType $type = ButtonType::Button,
		bool $disabled = false,
	) {
		parent::__construct(
			$child,
			$background,
			$textStyle,
			$padding,
			$borderRadius,
			$rank,
			$type,
			$disabled,
		);
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);

		$attributes['php-click'] = $this->onclick;

		return $attributes;
	}
}
