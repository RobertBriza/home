<?php

declare(strict_types=1);

namespace App\System\Application\Mapping\Map\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class SingleIntCollectionTypeMap implements CollectionTypeMap
{
	public function __construct(
		private readonly EntityManagerInterface $em,
	) {
	}

	/** @inheritDoc */
	public function isValid(mixed $value, string $className): bool
	{
		return is_int($value) && class_exists($className);
	}

	/** @inheritDoc */
	public function map(mixed $value, string $className): ArrayCollection
	{
		$entity = $this->em->find($className, $value);

		if ($entity === null) {
			return new ArrayCollection([]);
		}

		return new ArrayCollection([$entity]);
	}
}
