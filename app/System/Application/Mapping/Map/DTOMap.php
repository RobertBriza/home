<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;
use app\System\Domain\Exception\DomainException;
use Doctrine\Inflector\Inflector;

final class DTOMap implements TypeMap
{
	/** @param TypeMap[] $typeMaps */
	public function __construct(
		private readonly Inflector $inflector,
		private readonly array $typeMaps,
	) {
	}

	#[\Override] public function isValid(mixed $value): bool
	{
		return is_object($value) && str_contains($value::class, 'DTO');
	}

	#[\Override] public function map(Entity $entity, string $property, mixed $value): void
	{
		if (preg_match('/^([^\\\\]+\\\\[^\\\\]+\\\\[^\\\\]+)\\\\/', $value::class, $matches) === false) {
			throw new DomainException('Invalid DTO namespace');
		}

		$subEntityName = sprintf('%s\Entity\%s', $matches[1], ucfirst($property));

		$subEntity = new $subEntityName();

		foreach (get_object_vars($value) as $propertyName => $propertyValue) {
			foreach ($this->typeMaps as $map) {
				if ($map->isValid($propertyValue)) {
					$map->map($subEntity, $propertyName, $propertyValue);
				}
			}
		}

		$entityName = substr($entity::class, strrpos($entity::class, '\\') + 1);

		$singularizedMethodName = 'set' . ucfirst($entityName);
		if (method_exists($subEntity, $singularizedMethodName)) {
			$subEntity->{$singularizedMethodName}($entity);
		}

		$pluralizedMethodName = 'add' . $this->inflector->pluralize(ucfirst($entityName));
		if (method_exists($subEntity, $pluralizedMethodName)) {
			$subEntity->{$pluralizedMethodName}($entity);
		}

		$entity->{'set' . ucfirst($property)}($subEntity);
	}
}