<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

final class QueryEntityMapper extends EntityMapper
{
	/** @var string[] */
	protected static array $allowedKeywords = ['Get', 'GetBy', 'Find', 'FindBy', 'Search'];

	protected function commandToEntity(Mapper $mapper, object $object): mixed
	{
		return $mapper->queryToEntity($object);
	}
}
