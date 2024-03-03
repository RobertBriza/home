<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Application\Helper\TransformClassName;
use app\System\Application\Wiring\Autowired;
use app\System\Domain\Entity\Entity;
use app\System\Domain\Exception\DomainException;
use Doctrine\Common\Collections\Collection;
use Exception;
use ReflectionClass;
use ReflectionException;

final class DTOMapper implements Autowired
{
	public function map(object $instance): object|array
	{
		if ($instance instanceof Collection) {
			$result = [];

			foreach ($instance as $key => $entity) {
				$result[$key] = $this->map($entity);
			}

			return $result;
		}

		$dtoClassName = TransformClassName::entityToDTO($instance::class);

		if (str_contains($dtoClassName, 'Nettrine\Proxy\__CG__\\')) {
			$dtoClassName = str_replace('Nettrine\Proxy\__CG__\\', '', $dtoClassName);
		}

		try {
			$reflection = new ReflectionClass($dtoClassName);
		} catch (ReflectionException $e) {
			throw new Exception($e->getMessage(), previous: $e);
		}

		$properties = [];
		foreach ($reflection->getProperties() as $property) {
			$method = null;
			foreach (['get', ''] as $prefix) {
				if (method_exists($instance, $prefix . ucfirst($property->getName()))) {
					$method = $prefix . ucfirst($property->getName());
					break;
				}
			}

			if ($method === null) {
				throw new DomainException(sprintf('Method %s not found', $property->getName()));
			}

			if ($instance->$method() instanceof Entity) {
				$properties[$property->getName()] = $this->map($instance->$method());
				continue;
			}

			$properties[$property->getName()] = $instance->$method();
		}

		return new $dtoClassName(...$properties);
	}
}
