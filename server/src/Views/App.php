<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Views;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\Foundation\ExternalScript;
use Elephox\Templar\Foundation\FullscreenBody;
use Elephox\Templar\Foundation\FullscreenDocument;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class App extends BuildWidget {
	public function __construct(
		protected readonly Widget $child,
		protected readonly string $scriptName,
	) {}

	protected function build(RenderContext $context): Widget {
		return new FullscreenDocument(
			new Head(
				children: [
					new ExternalScript("js/$this->scriptName.js"),
				],
			),
			new FullscreenBody(
				$this->child,
			),
		);
	}
}
