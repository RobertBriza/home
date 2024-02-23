<?php

declare(strict_types=1);

namespace App\System\Application\Mapping;

use App\System\Domain\Entity\Entity;

final class CommandEntityMapper extends EntityMapper
{
	/** @var string[] */
	protected static array $allowedKeywords = ['Create', 'Update', 'Delete'];

	protected function commandToEntity(Mapper $mapper, object $object): ?Entity
	{
		return $mapper->commandToEntity($object);
	}
}
