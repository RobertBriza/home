<?php

declare(strict_types=1);

namespace App\System\Application\Mapping\Map;

use App\System\Application\Exception\ApplicationException;
use App\System\Application\Mapping\Map\Collection\CollectionTypeMap;
use App\System\Domain\Entity\Entity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Inflector\Inflector;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CollectionMap implements TypeMap
{
	/** @param array<CollectionTypeMap> $collectionMaps */
	public function __construct(
		private array $collectionMaps,
		private EntityManagerInterface $em,
		private Inflector $inflector,
	) {
	}

	public function isValid(array $data): bool
	{
		return $this->isCollection($data['type']);
	}

	public function map(Entity $entity, string $property, array $data): void
	{
		$propertyName = ucfirst(substr($property, 0, -1));

		$className = $this->getFullClassName($propertyName);

		foreach ($this->collectionMaps as $collectionMap) {
			if ($collectionMap->isValid($data['value'], $className)) {
				$propertyValue = $collectionMap->map($data['value'], $className);
				$this->setCollection($entity, $propertyName, $propertyValue);

				return;
			}
		}
	}

	/** @param Collection<int, object> $newCollection */
	public function setCollection(Entity $entity, string $propertyName, Collection $newCollection): void
	{
		$propertyNamePlural = $this->inflector->pluralize($propertyName);

		$set = 'set' . $propertyNamePlural;
		$get = 'get' . $propertyNamePlural;
		$add = 'add' . $propertyName;
		$remove = 'remove' . $propertyName;

		if (method_exists($entity, $set) === false) {
			throw new ApplicationException('Method ' . $set . ' does not exist in entity ' . $entity::class);
		}

		if (method_exists($entity, $get) === false) {
			throw new ApplicationException('Method ' . $get . ' does not exist in entity ' . $entity::class);
		}

		if (method_exists($entity, $add) === false) {
			throw new ApplicationException('Method ' . $add . ' does not exist in entity ' . $entity::class);
		}

		if (method_exists($entity, $remove) === false) {
			throw new ApplicationException('Method ' . $remove . ' does not exist in entity ' . $entity::class);
		}

		$oldCollection = $entity->$get();

		foreach ($oldCollection as $oldEntity) {
			if ($newCollection->contains($oldEntity)) {
				$newCollection->removeElement($oldEntity);
				continue;
			}

			$entity->$remove($oldEntity);
		}

		foreach ($newCollection as $newEntity) {
			$entity->$add($newEntity);
		}

		$entity->$set($newCollection);
	}

	/** @return class-string */
	private function getFullClassName(string $entityName): string
	{
		foreach ($this->em->getMetadataFactory()->getLoadedMetadata() as $className => $metadata) {
			if (is_int($className)) {
				throw new ApplicationException('Int class name just doesnt make sense');
			}

			if (basename(str_replace('\\', '/', $className)) === $entityName && class_exists($className)) {
				return $className;
			}
		}

		throw new ApplicationException('Could not find entity with name ' . $entityName);
	}

	private function isCollection(string $type): bool
	{
		return $type === Collection::class;
	}
}
