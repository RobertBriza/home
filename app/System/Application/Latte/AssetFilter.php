<?php

declare(strict_types=1);

namespace app\System\Application\Latte;

use app\System\Application\Vite\Vite;
use Nette\Utils\JsonException;

class AssetFilter
{
	public function __construct(
		private Vite $vite,
	) {
	}

	/**
	 * @throws JsonException
	 */
	public function __invoke(string $path): string
	{
		return $this->vite->getAsset($path);
	}
}
