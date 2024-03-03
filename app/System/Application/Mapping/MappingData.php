<?php
declare(strict_types=1);

namespace app\System\Application\Mapping;

final class MappingData
{
	public string $cqrsEntityNamespace;
	public string $dtoName;
	public string $entityName;
	public int $id;
	public bool $isDTO = false;
	public bool $isEntity = false;
	public bool $isParametrized;
	public MappingMethod $method;
	public array $properties = [];
	public string $repositoryName;
	public string $subjectName;
	public bool $toDTO;
}