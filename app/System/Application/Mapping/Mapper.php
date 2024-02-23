<?php

declare(strict_types=1);

namespace App\System\Application\Mapping;

use App\System\Application\CQRS\Command\CreateCommand;
use App\System\Application\CQRS\Command\DeleteCommand;
use App\System\Application\CQRS\Command\UpdateCommand;
use App\System\Application\CQRS\Query\Query;
use App\System\Application\Mapping\Map\TypeMap;
use App\System\Application\Wiring\Autowired;
use App\System\Domain\Entity\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use ReflectionClass;
use ReflectionNamedType;

abstract class Mapper implements Autowired
{
	protected EntityManagerInterface $em;
	protected string $entity;
	/** @var TypeMap[] $typeMaps */
	protected array $typeMaps = [];

	/**
	 * @template T of Entity
	 * @param EntityRepository<T> $repository
	 */
	public function __construct(protected EntityRepository $repository)
	{
		$this->entity = $this->repository->getClassName();
	}

	public function commandToEntity(object $command): Entity
	{
		if ($command instanceof CreateCommand) {
			$entity = new $this->entity();

			if ($entity instanceof Entity === false) {
				throw new Exception('Entity must be an instance of Entity');
			}

			$this->fillEntity($this->mapCommandToEntity($command, $entity), $entity);

			return $entity;
		}

		if ($command instanceof UpdateCommand) {
			$entity = $this->repository->find($command->id);

			if ($entity === null) {
				throw new Exception('Entity not found');
			}

			$this->fillEntity($this->mapCommandToEntity($command, $entity), $entity);

			return $entity;
		}

		if ($command instanceof DeleteCommand) {
			$entity = $this->repository->find($command->id);

			if ($entity === null) {
				throw new Exception('Entity not found');
			}

			return $entity;
		}

		throw new Exception('Command not found');
	}

	public function queryToEntity(object $query): mixed
	{
		if ($query instanceof Query) {
			return $this->repository->findBy($query->findCriteria());
		}

		throw new Exception('Query type not found');
	}

	/** @param TypeMap[] $typeMaps */
	public function setTypeMaps(array $typeMaps): void
	{
		$this->typeMaps = $typeMaps;
	}

	/** @param array<string, array{type: string, value: mixed}> $match */
	private function fillEntity(array $match, Entity $entity): void
	{
		foreach ($match as $property => $data) {
			$this->fillEntityProperty($data, $entity, $property);
		}
	}

	/** @param array{type: string, value: mixed} $data */
	private function fillEntityProperty(array $data, Entity $entity, string $property): void
	{
		foreach ($this->typeMaps as $typeMap) {
			if ($typeMap->isValid($data)) {
				$typeMap->map($entity, $property, $data);

				return;
			}
		}
	}

	/** @return  array<string, string> */
	private function getProperties(object $class): array
	{
		$reflectedClass = new ReflectionClass($class);
		$properties = [];

		foreach ($reflectedClass->getProperties() as $property) {
			$type = $property->getType();

			if ($type instanceof ReflectionNamedType === false) {
				continue;
			}

			$properties[$property->name] = $type->getName();
		}

		return $properties;
	}

	/** @return array<string, array{type: string, value: mixed}> */
	private function mapCommandToEntity(object $command, mixed $entity): array
	{
		$commandProperties = $this->getProperties($command);
		$entityProperties = $this->getProperties($entity);

		$match = [];

		foreach ($commandProperties as $commandProperty => $type) {
			$plural = $this->matchPlural($commandProperty, $entityProperties);
			if ($plural !== null) {
				$match[$plural] = [
					"type" => $entityProperties[$plural],
					"value" => $command->$commandProperty,
				];
			}

			if (array_key_exists($commandProperty, $entityProperties)) {
				$match[$commandProperty] = [
					"type" => $entityProperties[$commandProperty],
					"value" => $command->$commandProperty,
				];
			}
		}

		return $match;
	}

	/** @param array<string, string> $entityProperties */
	private function matchPlural(string $commandProperty, array $entityProperties): ?string
	{
		$plural = $commandProperty . 's';

		if (array_key_exists($commandProperty . 's', $entityProperties)) {
			return $plural;
		}

		$plural = substr($commandProperty, 0, -1) . 'es';

		if (array_key_exists($plural, $entityProperties)) {
			return $plural;
		}

		return null;
	}
}
