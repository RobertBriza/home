<?php

declare(strict_types=1);

namespace App\System\Application\Mapping\Map\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class MultipleIntCollectionTypeMap implements CollectionTypeMap
{
	public function __construct(
		private readonly EntityManagerInterface $em,
	) {
	}

	public function isValid(mixed $value, string $className): bool
	{
		return is_array($value) && class_exists($className);
	}

	/** @inheritDoc */
	public function map(mixed $value, string $className): ArrayCollection
	{
		return new ArrayCollection($this->em->getRepository($className)->findBy([
			'id' => $value,
		]));
	}
}
