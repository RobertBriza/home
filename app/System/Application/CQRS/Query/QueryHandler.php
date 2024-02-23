<?php

declare(strict_types=1);

namespace app\System\Application\CQRS\Query;

use app\System\Application\Mapping\QueryEntityMapper;
use app\System\Application\Wiring\Autowired;
use Doctrine\ORM\EntityManagerInterface;

abstract class QueryHandler implements Autowired
{
	protected EntityManagerInterface $em;
	protected QueryEntityMapper $mapper;

	public function map(object $command): mixed
	{
		return $this->mapper->map($command);
	}

	public function setEntityManager(EntityManagerInterface $em): void
	{
		$this->em = $em;
	}

	/** @internal */
	public function setMapper(QueryEntityMapper $mapper): void
	{
		$this->mapper = $mapper;
	}
}
