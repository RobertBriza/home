<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Application\CQRS\Command\CreateCommand;
use app\System\Application\CQRS\Command\DeleteCommand;
use app\System\Application\CQRS\Command\UpdateCommand;
use app\System\Application\CQRS\Query\Query;
use app\System\Application\Exception\ApplicationException;
use app\System\Application\Mapping\Map\TypeMap;
use app\System\Application\Wiring\Autowired;
use app\System\Domain\Entity\Entity;
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
		//TODO: getBy
		if ($query instanceof Query) {
			$result = $this->repository->findBy($query->findCriteria());

			if ($result === []) {
				return null;
			}

			if (count($result) === 1) {
				return $result[0];
			}

			return $result;
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
				throw new \ReflectionException('Property type not found');
			}

			$properties[$property->name] = $type->getName();
		}

		return $properties;
	}

	/** @return array<string, array{type: string, value: mixed}> */
	private function mapCommandToEntity(object $command, mixed $entity): array
	{
		$hasDTO = isset($command->dto);

		if ($command instanceof CreateCommand === false && $hasDTO) {
			throw new ApplicationException('DTO is supported only for CreateCommand');
		}

		$command = $hasDTO ? $command->dto : $command;

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
				$value = $command->$commandProperty;
				bdump($command->$commandProperty);
				if (class_exists($command->$commandProperty) && str_ends_with($command->$commandProperty::class, 'DTO')) {
					$value = $value->toEntity();
				}

				$match[$commandProperty] = [
					"type" => $entityProperties[$commandProperty],
					"value" => $value,
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
