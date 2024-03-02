<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Domain\Entity\Entity;
use app\System\Domain\Exception\DomainException;
use Doctrine\DBAL\Exception\TableNotFoundException;

final class CommandEntityMapper extends EntityMapper
{
	/** @var string[] */
	protected static array $allowedKeywords = ['Create', 'Update', 'Delete'];

	protected function cqrsObjectToEntity(Mapper $mapper, object $object): ?Entity
	{
		try {
			return $mapper->commandToEntity($object);
		} catch (TableNotFoundException $e) {
			throw new DomainException($e->getMessage(), previous: $e);
		}
	}
}
