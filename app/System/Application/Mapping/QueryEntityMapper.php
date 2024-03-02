<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Domain\Exception\DomainException;
use Doctrine\DBAL\Exception\TableNotFoundException;

final class QueryEntityMapper extends EntityMapper
{
	/** @var string[] */
	protected static array $allowedKeywords = ['Get', 'GetBy', 'Find', 'FindBy', 'Search'];

	protected function cqrsObjectToEntity(Mapper $mapper, object $object): mixed
	{
		try {
			return $mapper->queryToEntity($object);
		} catch (TableNotFoundException $e) {
			throw new DomainException($e->getMessage(), previous: $e);
		}
	}
}
