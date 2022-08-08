<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Widgets;

use Elephox\Templar\Foundation\Input;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\InputType;
use Elephox\Templar\RenderContext;

class LevelInput extends Input {
	public function __construct(
		InputType $type,
		protected readonly string $phpValue,
		protected readonly bool $watch = false,
		protected readonly array $attributes = [],
		?bool $autocomplete = null,
		bool $autofocus = false,
		bool $disabled = false,
		bool $formnovalidate = false,
		?string $list = null,
		?string $name = null,
		?string $pattern = null,
		?string $placeholder = null,
		bool $readonly = false,
		bool $required = false,
		?int $size = null,
		?string $value = null
	) {
		parent::__construct(
			$type,
			$autocomplete,
			$autofocus,
			$disabled,
			$formnovalidate,
			$list,
			$name,
			$pattern,
			$placeholder,
			$readonly,
			$required,
			$size,
			$value,
		);
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->type,
			$this->attributes,
		);
	}

	protected function getAttributes(RenderContext $context): array {
		$attributes = parent::getAttributes($context);

		$attributes['php-value'] = $this->phpValue;

		if ($this->watch) {
			$attributes['php-watch'] = '';
		}

		return array_merge($attributes, $this->attributes);
	}
}
