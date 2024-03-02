<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Application\Mapping\Exception\ResolverException;
use Doctrine\Inflector\Inflector;

final class MapperNameResolver
{
	/** @param Mapper[] $mappers */
	public function __construct(protected array $mappers, private readonly Inflector $inflector)
	{
	}

	public function getMapper(object $command): Mapper
	{
		$entityName = $this->getEntityName($command);

		foreach ($this->mappers as $mapper) {
			$className = $this->getClassName($mapper);
			if (preg_match('/^[A-Z][a-z]+/', $className, $matches) === false) {
				throw new ResolverException(sprintf('Invalid mapper name for entity %s', $entityName));
			}

			if ($matches[0] === $entityName) {
				return $mapper;
			}
		}

		throw new ResolverException(sprintf('Map for entity %s not found', $entityName));
	}

	public function getMethodTypeFromClassName(string $className): string
	{
		if (preg_match('/^[A-Z][a-z]+/', $className, $matches) === false) {
			throw new ResolverException(sprintf('Invalid command name for mapping %s', $className));
		}

		return $matches[0];
	}

	/**
	 * @param object $command
	 * @return string
	 */
	private function getClassName(object $command): string
	{
		return basename(str_replace('\\', '/', $command::class));
	}

	private function getEntityName(object $command): string
	{
		$className = $this->getClassName($command);

		foreach (['By', 'DTO'] as $keyword) {
			$className = preg_replace(
				sprintf('/%s.*/', $keyword),
				'',
				$className,
			);
		}

		return $this->inflector->singularize(
			substr(
				$className,
				strlen($this->getMethodTypeFromClassName($className)),
			),
		);
	}
}
