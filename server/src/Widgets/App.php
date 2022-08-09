<?php
declare(strict_types=1);

namespace RicardoBoss\Level\Widgets;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\Foundation\ExternalScript;
use Elephox\Templar\Foundation\FullscreenBody;
use Elephox\Templar\Foundation\FullscreenDocument;
use Elephox\Templar\Foundation\Head;
use Elephox\Templar\Foundation\InlineScript;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class App extends BuildWidget {
	public function __construct(
		protected readonly Widget $child,
		protected readonly ?string $scriptName,
	) {}

	protected function build(RenderContext $context): Widget {
		$headChildren = [];

		if ($this->scriptName !== null) {
			$headChildren[] = new ExternalScript("js/framework.js", defer: true);
			$headChildren[] = new InlineScript("document.querySelector('script').addEventListener('load', () => createApp('ws://localhost:8080/$this->scriptName'));");
		}

		return new FullscreenDocument(
			new Head(
				children: $headChildren,
			),
			new FullscreenBody(
				$this->child,
			),
		);
	}
}
