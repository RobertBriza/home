<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Domain\Entity\Entity;

final class CommandEntityMapper extends EntityMapper
{
	/** @var string[] */
	protected static array $allowedKeywords = ['Create', 'Update', 'Delete'];

	protected function commandToEntity(Mapper $mapper, object $object): ?Entity
	{
		return $mapper->commandToEntity($object);
	}
}
