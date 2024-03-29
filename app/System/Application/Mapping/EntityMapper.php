<?php

declare(strict_types=1);

namespace app\System\Application\Mapping;

use app\System\Application\Wiring\Autowired;

abstract class EntityMapper implements Autowired
{
	/** @var string[] $allowedKeywords */
	protected static array $allowedKeywords = [];

	public function __construct(protected MapperNameResolver $nameResolver)
	{
	}

	public function isValid(object $object): bool
	{
		return in_array($this->nameResolver->getMethodTypeFromClassName($object::class), self::$allowedKeywords, true);
	}

	public function map(object $object): mixed
	{
		return $this->cqrsObjectToEntity($this->nameResolver->getMapper($object), $object);
	}

	abstract protected function cqrsObjectToEntity(Mapper $mapper, object $object): mixed;
}
