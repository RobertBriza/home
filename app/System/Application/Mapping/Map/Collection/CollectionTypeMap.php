<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map\Collection;

use app\System\Application\Wiring\Autowired;
use Doctrine\Common\Collections\ArrayCollection;

interface CollectionTypeMap extends Autowired
{
	/** @param class-string $className */
	public function isValid(mixed $value, string $className): bool;

	/**
	 * @param class-string $className
	 * @return ArrayCollection<int, object>
	 */
	public function map(mixed $value, string $className): ArrayCollection;
}
