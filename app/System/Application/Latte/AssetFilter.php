<?php

namespace App\System\Application\Latte;

use App\System\Application\Vite\Vite;
use Nette\Utils\JsonException;

class AssetFilter
{
    public function __construct(
        private Vite $vite,
    ) {}

    /**
     * @throws JsonException
     */
    public function __invoke(string $path): string
    {
        return $this->vite->getAsset($path);
    }
}
