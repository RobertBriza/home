<?php
declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Application\Mapping\Map\TypeMap;
use app\System\Application\Wiring\Autowired;
use app\System\Domain\Entity\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class Mapper implements Autowired
{
	private MappingData $data;
	private EntityRepository $repository;

	/** @param TypeMap[] $typeMaps */
	public function __construct(
		private readonly MappingDataFactory $factory,
		private readonly EntityManagerInterface $em,
		private readonly DTOMapper $dtoMapper,
		private readonly array $typeMaps,
	) {
	}

	public function map(object $object): mixed
	{
		$this->data = $this->factory->create($object);
		$this->repository = $this->em->getRepository($this->data->entityName);

		$result = $this->mapEntity();

		if ($result !== null && $this->data->toDTO) {
			dumpe($this->dtoMapper->map($result));
		}

		return $result;
	}

	/**
	 * @return Entity|mixed|null
	 */
	public function mapEntity(): mixed
	{
		$result = null;

		if (
			$this->data->method === MappingMethod::Get
			|| $this->data->method === MappingMethod::Delete
		) {
			$result = $this->getEntity();
		}

		if ($this->data->method === MappingMethod::Find) {
			$result = $this->findEntities();
		}

		if ($this->data->method === MappingMethod::Create) {
			$result = new $this->data->entityName();
			$this->fillEntity($result);
		}

		if ($this->data->method === MappingMethod::Update) {
			/**
			 * TODO:
			 * $result = $this->getEntity();
			 * $this->fillEntity($result);
			 * */
		}

		return $result;
	}

	private function fillEntity(Entity $entity): void
	{
		foreach ($this->data->properties as $name => $value) {
			foreach ($this->typeMaps as $map) {
				if ($map->isValid($value)) {
					$map->map($entity, $name, $value);
				}
			}
		}
	}

	private function findEntities(): array
	{
		return $this->repository->findBy($this->data->properties);
	}

	/**
	 * @template T of Entity
	 * @return Entity|null
	 */
	private function getEntity(): ?Entity
	{
		if ($this->data->isEntity) {
			return $this->data->properties['entity'];
		}

		return $this->data->isParametrized
			? $this->repository->findOneBy($this->data->properties)
			: $this->repository->find($this->data->id);
	}
}