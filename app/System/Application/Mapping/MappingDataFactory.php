<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Application\Wiring\Autowired;
use app\System\Domain\Exception\DomainException;
use Doctrine\Inflector\Inflector;
use Exception;

final class MappingDataFactory implements Autowired
{
	protected MappingData $data;

	public function __construct(
		private readonly Inflector $inflector,
	) {
	}

	public function create(object $object): MappingData
	{
		$this->data = new MappingData;
		$this->setBaseData($object);
		$this->setDomainClassNames();
		$this->setParameters($object);

		return $this->data;
	}

	private function getEntityName(string $keyword, string $objectName): string
	{
		if (preg_match(sprintf('/^([a-zA-Z]+)%s/', $keyword), $objectName, $matches)) {
			return $matches[1];
		}

		throw new DomainException(sprintf('Unsupported entity name %s', $objectName));
	}

	private function getMappingMethod(string $objectName): MappingMethod
	{
		$method = null;
		foreach (MappingMethod::cases() as $case) {
			if (str_contains($objectName, $case->value)) {
				$method = $case;

				break;
			}
		}

		if ($method === null) {
			throw new Exception(sprintf('Unsupported method type %s', $objectName));
		}

		return $method;
	}

	private function getNamespace(object $object, string $objectName): string
	{
		return substr($object::class, 0, -strlen($objectName));
	}

	private function setBaseData(object $object): void
	{
		$objectName = basename(str_replace('\\', '/', $object::class));

		$method = $this->getMappingMethod($objectName);
		$toDTO = str_contains($objectName, 'DTO');
		$isParametrized = str_contains($objectName, 'By');

		$subjectName = substr($objectName, strlen($method->value));

		if ($toDTO) {
			$subjectName = $this->getEntityName('DTO', $subjectName);
		}

		if ($isParametrized && $toDTO === false) {
			$subjectName = $this->getEntityName('By', $subjectName);
		}

		if ($isParametrized === false && ($method === MappingMethod::Create || $method === MappingMethod::Update)) {
			$isParametrized = true;
		}

		$this->data->cqrsEntityNamespace = $this->getNamespace($object, $objectName);
		$this->data->method = $method;
		$this->data->toDTO = $toDTO;
		$this->data->isParametrized = $isParametrized;
		$this->data->subjectName = $this->inflector->singularize($subjectName);
	}

	private function setDomainClassNames(): void
	{
		$pattern = '/^([^\\\\]+\\\\[^\\\\]+)\\\\/';
		if (preg_match($pattern, $this->data->cqrsEntityNamespace, $matches)) {
			$result = $matches[1];
			$this->data->repositoryName = sprintf("%s\Domain\Repository\%sRepository", $result, $this->data->subjectName);
			$this->data->entityName = sprintf("%s\Domain\Entity\%s", $result, $this->data->subjectName);
			$this->data->dtoName = sprintf("%s\Domain\DTO\%sDTO", $result, $this->data->subjectName);

			return;
		}

		throw new DomainException(sprintf('Unsupported namespace %s', $this->data->cqrsEntityNamespace));
	}

	/** @param $properties array{id: int} */
	private function setId(array $properties): void
	{
		$this->data->id = $properties['id'];
	}

	/** @param $properties array{id: int[]} */
	private function setIds(array $properties): void
	{
		$this->data->properties = $properties;
	}

	/** @param $properties array<string, mixed> */
	private function setObjectProperties(array $properties): void
	{
		$this->data->properties = $properties;
	}

	private function setParameters(object $object): void
	{
		$params = get_object_vars($object);
		
		if ($params === []) {
			// empty array
			$this->data->isParametrized = true;

			return;
		}

		if ($this->data->isParametrized) {
			//If only one parameter is passed, it could be a DTO
			if (count($params) > 1) {
				$this->setObjectProperties($params);

				if ($this->data->method === MappingMethod::Update) {
					$this->setId($params['id']);
				}

				return;
			}

			$param = reset($params);

			if (is_object($param)) {
				$isEntity = $this->data->entityName === $param::class;
				$isDTO = $this->data->dtoName === $param::class;
				if ($isEntity) {
					$this->data->isEntity = true;
					$this->setObjectProperties(['entity' => $param]);

					return;
				}

				if ($isDTO) {
					$this->data->isDTO = true;
					$this->setObjectProperties(get_object_vars($param));

					return;
				}

				$this->setObjectProperties($params);

				return;
			}
		}

		$this->data->method === MappingMethod::Find
			? $this->setIds($params)
			: $this->setId($params);
	}
}