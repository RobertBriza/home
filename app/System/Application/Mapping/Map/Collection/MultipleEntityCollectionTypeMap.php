<?php

declare(strict_types=1);

namespace App\System\Application\Mapping\Map\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class MultipleEntityCollectionTypeMap implements CollectionTypeMap
{
	public function isValid(mixed $value, string $className): bool
	{
		return $value instanceof Collection && $value->first() instanceof $className;
	}

	public function map(mixed $value, string $className): ArrayCollection
	{
		return $value;
	}
}
