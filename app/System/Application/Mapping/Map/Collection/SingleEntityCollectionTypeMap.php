<?php

declare(strict_types=1);

namespace App\System\Application\Mapping\Map\Collection;

use Doctrine\Common\Collections\ArrayCollection;

class SingleEntityCollectionTypeMap implements CollectionTypeMap
{
	public function isValid(mixed $value, string $className): bool
	{
		return $value instanceof $className;
	}

	public function map(mixed $value, string $className): ArrayCollection
	{
		return new ArrayCollection([$value]);
	}
}
